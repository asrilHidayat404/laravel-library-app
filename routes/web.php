<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// ================= HALAMAN UMUM =================
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Dashboard utama (bisa diarahkan sesuai role)
    Route::get('/', function () {
        if (auth()->user()->role->role_name === 'admin') {
            return view('pages.admin.index');
        } else {
            return view('pages.member.index');
        }
    })->name('index');

    // Halaman umum untuk semua user
    Route::get('/settings', function () {
        return "Setting page(general)";
    })->name('settings');
});

// ================= ADMIN =================
Route::middleware(['auth', 'isAdmin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/users', function () {
        return view('pages.admin.users.index');
    })->name('users');

    Route::get('/books', function () {
        return view('pages.admin.books.index');
    })->name('books');
});

// ================= MEMBER =================
Route::middleware(['auth', 'isMember'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/profile', function () {
        return view('pages.member.profile');
    })->name('profile');

    Route::get('/books', function () {
        return view('pages.member.books.index');
    })->name('books');
});

require __DIR__.'/auth.php';
