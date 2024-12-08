<?php

use Illuminate\Support\Facades\Route;
use Packages\ProjectExport\Http\Controllers\ProjectExportController;

Route::get('/project-export/cursor', [ProjectExportController::class, 'cursor'])->name('project-export.cursor');
