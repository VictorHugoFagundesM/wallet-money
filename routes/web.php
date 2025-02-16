<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/transaction', [TransactionController::class, 'create'])->name('transaction.create')->name('transaction.create');
    Route::get('/transaction/{id}', [TransactionController::class, 'show'])->where('id', '[0-9]+')->name('transaction.show');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store')->name('transaction.store');
});

require __DIR__.'/auth.php';
