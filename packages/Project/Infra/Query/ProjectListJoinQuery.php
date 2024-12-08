<?php

namespace Packages\Project\Infra\Query;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

/**
 * プロジェクト一覧取得クエリ（JOIN）
 */
class ProjectListJoinQuery
{
    public function get(): Collection
    {
        return $this->query()->get();
    }

    public function cursor(): LazyCollection
    {
        return LazyCollection::make(function () {
            yield from $this->query()->cursor();
        });
    }

    public function query(): Builder
    {
        return DB::table('projects')
            ->select([
                'projects.*',
                'tasks.id as task_id',
                'tasks.name as task_name',
                'tasks.description as task_description',
            ])
            ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->orderBy('projects.id')
            ->orderBy('task_id');
    }
}
