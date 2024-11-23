<?php

use App\Http\Controllers\User\UserDownloadController;
use Illuminate\Support\Facades\Route;
use Packages\Project\Http\Controllers\ProjectDownloadController;
use Packages\Project\Http\Controllers\ProjectDownloadDataController;
use Packages\Project\Http\Controllers\ProjectExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/download', UserDownloadController::class)->name('users.download');
Route::get('/projects/download', [ProjectDownloadController::class, 'download'])->name('projects.download');
Route::get('/projects/download/logic', [ProjectDownloadController::class, 'logic'])->name('projects.download.logic');
Route::get('/projects/data', ProjectDownloadDataController::class)->name('projects.data');
Route::get('/projects/export', [ProjectExportController::class, 'export'])->name('projects.export');
Route::get('/projects/chunk', [ProjectExportController::class, 'chunk'])->name('projects.chunk');
Route::get('/projects/generator', [ProjectExportController::class, 'generator'])->name('projects.generator');
Route::get('/projects/logic', [ProjectExportController::class, 'logic'])->name('projects.logic');
