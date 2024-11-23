<?php

namespace Packages\Project\Exports;

use Generator;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Packages\Project\Infra\Query\ProjectListQuery;

class ProjectsExportWithGenerator implements FromGenerator, WithHeadings
{
    public function __construct(
        protected ProjectListQuery $projectListQuery
    ) {}

    /**
     * @return Generator
     * @description use 203MB!!
     */
    public function generator(): Generator {
        $projects = $this->projectListQuery->get();
        foreach ($projects as $project) {
            $project->tasks = explode(',', $project->tasks);
            yield [
                ...[
                    $project->id,
                    $project->name,
                    $project->description,
                    $project->created_at,
                    $project->updated_at,
                ],
                ...$project->tasks,
            ];
        }
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Created At',
            'Updated At',
            'Tasks',
        ];
    }
}
