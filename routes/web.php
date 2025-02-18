<?php

use App\Http\Controllers\BankSlipController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    // rotas de perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Rotas de transações
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/', [TransactionController::class, 'create'])->name('create');
        Route::get('/{id}/info', [TransactionController::class, 'info'])->where('id', '[0-9]+')->name('info');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
    });

    // Rotas de boletos
    Route::prefix('bank-slip')->name('bank-slip.')->group(function () {
        Route::get('/', [BankSlipController::class, 'index'])->name('index');
        Route::get('/create', [BankSlipController::class, 'create'])->name('create');
        Route::get('/{id}/info', [BankSlipController::class, 'info'])->where('id', '[0-9]+')->name('info');
        Route::post('/', [BankSlipController::class, 'store'])->name('store');
        Route::get('/payment', [BankSlipController::class, 'payment'])->name('payment');
        Route::post('/payment/check', [BankSlipController::class, 'paymentCheck'])->name('payment.check');
        Route::get('/payment/{id}/confirmation', [BankSlipController::class, 'paymentConfirmation'])->name('payment.confirmation');
    });

    // Rotas de estornos
    Route::prefix('refund')->name('refund.')->group(function () {
        Route::get('/{id}/request', [RefundController::class, 'create'])->where('id', '[0-9]+')->name('create');
        Route::post('/', [RefundController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
