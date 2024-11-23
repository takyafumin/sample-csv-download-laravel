<?php

namespace Packages\Project\Infra\Query;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

/**
 * プロジェクト一覧取得クエリ
 */
class ProjectListQuery
{
    /**
     * Get the list of projects with their tasks.
     */
    public function get(): Collection
    {
        return $this->query()->get();
    }

    public function lazy(): LazyCollection
    {
        return $this->query()->lazy();
    }

    public function query(): Builder
    {
        return DB::table('projects')
            ->select([
                'projects.*',
                DB::raw(
                    'GROUP_CONCAT(CONCAT(tasks.id, ",", tasks.name, ",", tasks.description) ORDER BY tasks.id, ",") as tasks'
                ),
            ])
            ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->groupBy('projects.id')
            ->orderBy('projects.id');
    }
}
