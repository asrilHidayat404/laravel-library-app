<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;

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

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {

    // Route dashboard utama
    Route::get('/', function () {
        if (auth()->user()->role->role_name === 'admin') {
            return view('pages.admin.index');
        } else {
            return view('pages.member.index');
        }
    })->name('index');

    // Routes khusus Admin
    Route::middleware(['isAdmin'])->group(function() {
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::get('/create', [MemberController::class, 'create'])->name('create');
            Route::post('/store', [MemberController::class, 'store'])->name('store');
            Route::get('/{member}/edit', [MemberController::class, 'edit'])->name('edit');
            Route::put('/{member}/update', [MemberController::class, 'update'])->name('update');
            Route::delete('/{member}/destroy', [MemberController::class, 'destroy'])->name('destroy');
        });
    });


    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/store', [BookController::class, 'store'])->name('store');
        Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
        Route::put('/{book}/update', [BookController::class, 'update'])->name('update');
        Route::delete('/{book}/destroy', [BookController::class, 'destroy'])->name('destroy');
    });

    // Routes khusus Member
    Route::middleware(['isMember'])->group(function() {
        Route::get('/profile', function () {
            return view('pages.member.profile');
        })->name('profile');
    });
});


require __DIR__.'/auth.php';
