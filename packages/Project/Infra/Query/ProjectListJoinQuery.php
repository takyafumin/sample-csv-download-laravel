<?php

namespace Packages\Project\Infra\Query;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class ProjectListJoinQuery
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
                'tasks.id as task_id',
                'tasks.name as task_name',
                'tasks.description as task_description',
            ])
            ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->orderBy('projects.id')
            ->orderBy('task_id');
    }
}
