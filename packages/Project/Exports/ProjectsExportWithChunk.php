<?php

namespace Packages\Project\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Packages\Project\Infra\Query\ProjectListQuery;

class ProjectsExportWithChunk implements FromQuery, WithCustomChunkSize, WithHeadings, WithMapping
{
    public function __construct(
        protected ProjectListQuery $projectListQuery
    ) {}

    public function map($row): array
    {
        // これはメモリエラーにならない
        // 46MB
        // return (array) $row;

        // これもメモリエラーにならない
        // 35MB
        // return [
        //     $row->id,
        //     $row->name,
        //     $row->description,
        //     $row->created_at,
        //     $row->updated_at,
        // ];

        // これもメモリエラーにならない
        // 35MB
        // $base = [
        //     $row->id,
        //     $row->name,
        //     $row->description,
        //     $row->created_at,
        //     $row->updated_at,
        // ];
        // return $base;

        // これはメモリエラーになる
        // $base = [
        //     $row->id,
        //     $row->name,
        //     $row->description,
        //     $row->created_at,
        //     $row->updated_at,
        // ];
        // $ext = explode(',', $row->tasks);
        // return $base + $ext;

        // これはメモリエラーになる
        // 127MB
        // return [
        //     $row->id,
        //     $row->name,
        //     $row->description,
        //     $row->created_at,
        //     $row->updated_at,
        // ] + explode(',', $row->tasks);

        // 10: 60MB
        // 11: 64MB
        // 12: 67MB
        // 13: 71MB
        // 14: 88MB
        // 15: 90MB
        // 19: 105MB
        // 20: 109MB
        return [
            $row->id,
            $row->name,
            $row->description,
            $row->created_at,
            $row->updated_at,
        ] + range(1, 19);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function query()
    {
        return $this->projectListQuery->query();
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
