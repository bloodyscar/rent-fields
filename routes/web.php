<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLapanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/lapangan', [UserLapanganController::class, 'index'])->middleware(['auth', 'verified'])->name('lapangan');


Route::get('/lapangan/get_jadwal', [UserLapanganController::class, 'get_jadwal'])->middleware(['auth', 'verified']);


Route::post('/lapangan/order', [UserLapanganController::class, 'postOrder'])->name('order.store');

Route::get('/lapangan/image/{id}', [UserLapanganController::class, 'newTab'])->name('order.newtab');

Route::get('/pembayaran', function () {
    return view('pembayaran.index');
})->middleware(['auth', 'verified'])->name('pembayaran');


Route::get('/pembayaran/get_order', [UserLapanganController::class, 'get_order'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
