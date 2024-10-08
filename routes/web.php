<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resources([
        'blog' => BlogController::class
    ]);
//    Route::any('/blog', [BlogController::class, 'index']);
    Route::post('/comment/{blogId}', [CommentController::class, 'store']);
    Route::delete('/comment/destroy', [CommentController::class, 'destroy']);
});

require __DIR__.'/auth.php';
