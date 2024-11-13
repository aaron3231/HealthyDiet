<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

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
    Route::get('/submit_comment', [CommentController::class, 'submit_comment'])->name('submit_comment');
});

Route::get('/fetch_comments', [CommentController::class, 'fetch_comments'])->name('fetch_comments');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/fitness_meal', function () {
    return view('fitness_meal');
});

Route::get('/mediterranean_restaurant', function () {
    return view('mediterranean_restaurant');
});

Route::get('/shopping', function () {
    return view('shopping');
});

Route::get('/filter', [SearchController::class, 'search_restaurants_from_adv'])->name('restaurant.search');


require __DIR__.'/auth.php';
