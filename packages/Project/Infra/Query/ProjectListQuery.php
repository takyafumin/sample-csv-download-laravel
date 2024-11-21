<?php

namespace Packages\Project\Infra\Query;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectListQuery
{
    /**
     * Get the list of projects with their tasks.
     */
    public function get(): Collection
    {
        return Project::query()
            ->limit(2)
            ->get();
    }
}
