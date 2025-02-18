<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesearchController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewssearchController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VideosearchController;
use App\Http\Controllers\MapsearchController;
use App\Http\Controllers\WebsearchController;
use App\Http\Controllers\UserController;
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
    Route::post('/knowledgegraph/edit/{id}', [WebsearchController::class, 'updateKnowledgeGraph']);

    /* Organic */
    Route::get('/organic/edit/{id}', [WebsearchController::class, 'editOrganic']);
    Route::post('/organic/edit/{id}', [WebsearchController::class, 'updateOrganic']);

    /* Priview */
    Route::get('/preview/edit/{id}', [WebsearchController::class, 'editPreview']);
    Route::post('/preview/edit/{id}', [WebsearchController::class, 'updatePreview']);

     /* Related Search */
     Route::get('/relatedsearch/edit/{id}', [WebsearchController::class, 'ediRelatedSearch']);
     Route::post('/relatedsearch/edit/{id}', [WebsearchController::class, 'updateRelatedSearch']);

     /* Image */
     Route::get('/imagesearch', [ImagesearchController::class, 'index']);
     Route::get('/imagesearch/create', [ImagesearchController::class, 'create']);
     Route::post('/imagesearch/create', [ImagesearchController::class, 'store']);
     Route::get('/imagesearch/edit/{id}', [ImagesearchController::class, 'edit']);
     Route::post('/imagesearch/edit/{id}', [ImagesearchController::class, 'update']);
     Route::delete('/imagesearch/delete/{id}', [ImagesearchController::class, 'destroy']);

     /* News */
     Route::get('/newssearch', [NewssearchController::class, 'index']);
     Route::get('/newssearch/create', [NewssearchController::class, 'create']);
     Route::post('/newssearch/create', [NewssearchController::class, 'store']);
     Route::get('/newssearch/edit/{id}', [NewssearchController::class, 'edit']);
     Route::post('/newssearch/edit/{id}', [NewssearchController::class, 'update']);
     Route::delete('/newssearch/delete/{id}', [NewssearchController::class, 'destroy']);

     /* Video */
     Route::get('/videosearch', [VideosearchController::class, 'index']);
     Route::get('/videosearch/create', [VideosearchController::class, 'create']);
     Route::post('/videosearch/create', [VideosearchController::class, 'store']);
     Route::get('/videosearch/edit/{id}', [VideosearchController::class, 'edit']);
     Route::post('/videosearch/edit/{id}', [VideosearchController::class, 'update']);
     Route::delete('/videosearch/delete/{id}', [VideosearchController::class, 'destroy']);

     /* Video */
     Route::get('/mapsearch', [MapsearchController::class, 'index']);
     Route::get('/mapsearch/create', [MapsearchController::class, 'create']);
     Route::post('/mapsearch/create', [MapsearchController::class, 'store']);
     Route::get('/mapsearch/edit/{id}', [MapsearchController::class, 'edit']);
     Route::post('/mapsearch/edit/{id}', [MapsearchController::class, 'update']);
     Route::delete('/mapsearch/delete/{id}', [MapsearchController::class, 'destroy']);

     /* User */
     Route::get('/user', [UserController::class, 'index']);
     Route::get('/user/create', [UserController::class, 'create']);
     Route::post('/user/create', [UserController::class, 'store']);
     Route::get('/user/edit/{id}', [UserController::class, 'edit']);
     Route::post('/user/edit/{id}', [UserController::class, 'update']);
     Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);
});