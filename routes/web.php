<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Middleware\LoginRegisterController;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Storage;

Route::get('/', [BookController::class, 'index'])->name('index')->middleware('auth');

Route::get('/welcome', function(){
    return view('welcome');
});

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
    Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware(['auth', 'admin']);
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');


Route::resource('gallery', GalleryController::class);
Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
Route::post('/upadate/{id}', [GalleryController::class, 'update'])->name('gallery.update');
Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');


Route::get('/send-email', [SendEmailController::class, 'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');
Route::get('/send-email/send/{email}/{name}', [SendEmailController::class, 'send'])->name('send-email.send');