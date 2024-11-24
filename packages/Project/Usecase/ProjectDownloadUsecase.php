<?php

namespace Packages\Project\Usecase;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Packages\Project\Exports\Dto\CsvRowDto;
use Packages\Project\Infra\Query\ProjectListQuery;

/**
 * ProjectDownload Usecase
 */
class ProjectDownloadUsecase
{
    private ProjectListQuery $projectListQuery;

    public function __construct(ProjectListQuery $projectListQuery)
    {
        $this->projectListQuery = $projectListQuery;
    }

    public function exec(): Collection
    {
        // プロジェクトデータ取得（タスクを含む）
        return $this->projectListQuery->get();
    }

    public function lazy(): LazyCollection
    {
        // プロジェクトデータ取得（タスクを含む）
        return $this->projectListQuery->lazy()
            ->map(function ($project) {
                $taskItems = collect(explode(',', $project->tasks))
                    ->chunk(3)
                    ->toArray();

                return new CsvRowDto(
                    $project->id,
                    $project->name,
                    $project->description,
                    $project->created_at,
                    $project->updated_at,
                    $taskItems
                );
            });
    }
}
