<?php

namespace Packages\ProjectExport\Usecase;

use Illuminate\Support\LazyCollection;
use Packages\ProjectExport\Infra\Query\ProjectListJoinQuery;
use Packages\ProjectExport\Usecase\Dto\ProjectTaskDto;

/**
 * ProjectDownload Usecase
 */
class ProjectDownloadUsecase
{
    /**
     * @param  ProjectListJoinQuery  $projectListQuery  プロジェクト一覧取得クエリ
     */
    public function __construct(
        private ProjectListJoinQuery $projectListQuery
    ) {}

    /**
     * 実行する
     *
     * @return LazyCollection<ProjectTaskDto>
     */
    public function exec(): LazyCollection
    {
        // プロジェクトデータ取得（タスクを含む）
        return $this->projectListQuery
            ->groupByProject()
            ->map(function ($project) {
                return new ProjectTaskDto(
                    $project->id,
                    $project->name,
                    $project->description,
                    $project->created_at,
                    $project->updated_at,
                    $project->tasks,
                );
            });
    }
}
