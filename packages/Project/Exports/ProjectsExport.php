<?php

namespace Packages\Project\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Packages\Project\Infra\Query\ProjectListQuery;

class ProjectsExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ProjectListQuery $projectListQuery
    ) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->projectListQuery->get();
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
