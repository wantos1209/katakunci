<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    abort(404);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () { 
    Route::post('/logout', [LoginController::class, 'logout']);
    
    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /* Site */
    Route::get('/site', [SiteController::class, 'index']);
    Route::get('/site/create', [SiteController::class, 'create']);
    Route::post('/site/create', [SiteController::class, 'store']);
    Route::get('/site/edit/{id}', [SiteController::class, 'edit']);
    Route::post('/site/edit/{id}', [SiteController::class, 'update']);
    Route::delete('/site/delete/{id}', [SiteController::class, 'destroy']);
});