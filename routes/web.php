<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [SearchController::class, 'search_restaurants_from_hybrid'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/bookmark', [BookmarkController::class, 'get_Bookmarks'])
->middleware(['auth', 'verified'])
->name('bookmark');

Route::get('/list', [SearchController::class, 'search_restaurants_from_list'])
    ->middleware(['auth', 'verified'])
    ->name('list');

Route::middleware('auth')->group(function () {
    Route::get('/set_bookmark', [BookmarkController::class, 'set_bookmark'])->name('set_bookmark');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
