<?php

use App\Http\Controllers\User\UserDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/download', UserDownloadController::class);
