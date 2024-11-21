<?php

namespace Packages\Project\Infra\Query;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProjectListQuery
{
    /**
     * Get the list of projects with their tasks.
     */
    public function get(): Collection
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
            ->limit(10000)
            ->get();
    }
}
