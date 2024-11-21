<?php

use App\Http\Controllers\User\UserDownloadController;
use Illuminate\Support\Facades\Route;
use Packages\Project\Http\Controllers\ProjectDownloadController;
use Packages\Project\Http\Controllers\ProjectDownloadDataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/download', UserDownloadController::class);
Route::get('/projects/download', ProjectDownloadController::class);
Route::get('/projects/data', ProjectDownloadDataController::class);
