<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\WebsearchController;
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

    /* Keywords */
    Route::get('/keyword', [KeywordController::class, 'index']);
    Route::get('/keyword/create', [KeywordController::class, 'create']);
    Route::post('/keyword/create', [KeywordController::class, 'store']);
    Route::get('/keyword/edit/{id}', [KeywordController::class, 'edit']);
    Route::post('/keyword/edit/{id}', [KeywordController::class, 'update']);
    Route::delete('/keyword/delete/{id}', [KeywordController::class, 'destroy']);

    /* Web */
    Route::get('/websearch', [WebsearchController::class, 'index']);
    Route::get('/websearch/create', [WebsearchController::class, 'create']);
    Route::post('/websearch/create', [WebsearchController::class, 'store']);
    Route::get('/websearch/edit/{id}', [WebsearchController::class, 'edit']);
    Route::post('/websearch/edit/{id}', [WebsearchController::class, 'update']);
    Route::delete('/websearch/delete/{id}', [WebsearchController::class, 'destroy']);

    /* Knowledge Graph */
    Route::get('/knowledgegraph/edit/{id}', [WebsearchController::class, 'editKnowledgeGraph']);
});