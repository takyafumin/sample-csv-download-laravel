<?php

namespace Packages\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Packages\Project\Exports\ProjectsExport;
use Packages\Project\Exports\ProjectsExportWithChunk;
use Packages\Project\Exports\ProjectsExportWithGenerator;
use Packages\Project\Exports\ProjectsExportWithLogic;
use Packages\Project\Infra\Query\ProjectListJoinQuery;
use Packages\Project\Infra\Query\ProjectListQuery;

class ProjectExportController extends Controller
{
    public function export()
    {
        return Excel::download(
            new ProjectsExport(new ProjectListQuery),
            'projects.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function chunk()
    {
        ini_set('memory_limit', '512M');

        return Excel::download(
            new ProjectsExportWithChunk(new ProjectListQuery),
            'projects.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function generator()
    {
        ini_set('memory_limit', '512M');

        return Excel::download(
            new ProjectsExportWithGenerator(new ProjectListQuery),
            'projects.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function logic()
    {
        ini_set('memory_limit', '512M');

        return Excel::download(
            new ProjectsExportWithLogic(new ProjectListJoinQuery),
            'projects.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
