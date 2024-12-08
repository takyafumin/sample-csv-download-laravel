<?php

namespace Packages\Project\Usecase;

use Illuminate\Support\LazyCollection;
use Packages\Project\Exports\Dto\CsvRowDto;
use Packages\Project\Infra\Query\ProjectListJoinQuery;

/**
 * ProjectDownload Usecase
 */
class ProjectDownloadByCursorUsecase
{
    public function __construct(private ProjectListJoinQuery $query) {}

    /**
     * @return LazyCollection<CsvRowDto>
     */
    public function exec(): LazyCollection
    {
        // クエリ実行
        $query = $this->query->cursor();

        return $query
            ->groupBy(function ($item) {
                return $item->id;
            })
            ->map(function ($groups) {
                $parent = $groups->first();

                return new CsvRowDto(
                    $parent->id,
                    $parent->name,
                    $parent->description,
                    $parent->created_at,
                    $parent->updated_at,
                    $groups->map(function ($group) {
                        return [
                            'id' => $group->task_id,
                            'name' => $group->task_name,
                            'description' => $group->task_description,
                        ];
                    })->toArray(),
                );
            });
    }
}
