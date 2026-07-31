<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::post('/administration/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/administration', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/administration/logout', [AdminController::class, 'logout'])->name('admin.logout');
