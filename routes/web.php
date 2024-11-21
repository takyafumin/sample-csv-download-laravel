<?php

use App\Http\Controllers\User\UserDownloadController;
use Illuminate\Support\Facades\Route;
use Packages\Project\Http\Controllers\ProjectDownloadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/download', UserDownloadController::class);
Route::get('/projects/download', ProjectDownloadController::class);
