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
Route::get('/projects/download', ProjectDownloadController::class)->name('projects.download');
Route::get('/projects/data', ProjectDownloadDataController::class)->name('projects.data');
Route::get('/projects/export', [ProjectExportController::class, 'export'])->name('projects.export');
Route::get('/projects/chunk', [ProjectExportController::class, 'chunk'])->name('projects.chunk');
