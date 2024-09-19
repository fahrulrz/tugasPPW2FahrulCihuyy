<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index'])->name('index');

// Menambahkan buku dengan input manual
Route::post('/addManualBook', [BookController::class, 'addManualBook'])->name('book.addManualBook');

// Menambahkan buku secara random
Route::post('/addRandom', [BookController::class, 'addRandom'])->name('book.addRandom');

// Menampilkan formulir edit
Route::get('/editBook/{id}', [BookController::class, 'edit'])->name('book.edit');

// Memperbarui data buku
Route::post('/updateBook/{id}', [BookController::class, 'update'])->name('book.update');
