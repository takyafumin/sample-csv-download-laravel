<?php

namespace Packages\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Packages\Project\Exports\ProjectsExport;
use Packages\Project\Exports\ProjectsExportWithChunk;
use Packages\Project\Infra\Query\ProjectListQuery;

class ProjectExportController extends Controller
{
    public function export()
    {
        $projectListQuery = new ProjectListQuery;

        return Excel::download(
            new ProjectsExport($projectListQuery),
            'projects.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function chunk()
    {
        $projectListQuery = new ProjectListQuery;

        ini_set('memory_limit', '512M');

        return Excel::download(
            new ProjectsExportWithChunk($projectListQuery),
            'projects.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
