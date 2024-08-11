<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);
});


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{user}', [AdminController::class, 'userBooks'])->name('admin.users.books');
    Route::get('/admin/books/{book}/edit', [AdminController::class, 'editBook'])->name('admin.books.edit');
    Route::put('/admin/books/{book}', [AdminController::class, 'updateBook'])->name('admin.books.update');
    Route::delete('/admin/books/{book}', [AdminController::class, 'deleteBook'])->name('admin.books.delete');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::resource('/admin/categories', CategoryController::class);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/',function() {
    return redirect('/login');
});

Route::get('books/export/excel/{user}', [BookController::class, 'exportExcel'])->name('books.export.excel');
Route::get('books/export/pdf/{user}', [BookController::class, 'exportPDF'])->name('books.export.pdf');
Route::get('users/{user}/books', [BookController::class, 'index'])->name('users.books');
