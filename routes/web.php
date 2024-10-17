<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
// use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Middleware\LoginRegisterController;

Route::get('/', [BookController::class, 'index'])->name('index')->middleware('auth');

// Menambahkan buku dengan input manual
Route::post('/addManualBook', [BookController::class, 'addManualBook'])->name('book.addManualBook');

// Menambahkan buku secara random
Route::post('/addRandom', [BookController::class, 'addRandom'])->name('book.addRandom');

// Menampilkan formulir edit
Route::get('/editBook/{id}', [BookController::class, 'edit'])->name('book.edit');

// Memperbarui data buku
Route::post('/updateBook/{id}', [BookController::class, 'update'])->name('book.update');

// Menghapus buku
Route::delete('/deleteBook/{id}', [BookController::class, 'destroy'])->name('book.destroy');


Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register')->middleware('guest');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware('auth');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});