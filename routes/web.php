<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('download/{model}', [DownloadController::class, 'getDownload']);

Route::get('profile', [ProfileController::class, 'getProfile'])->name('profile');
