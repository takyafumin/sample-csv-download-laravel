<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserDownloadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/download', UserDownloadController::class);

