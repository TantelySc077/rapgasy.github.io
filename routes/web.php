<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification publiques
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Routes clients authentifiés
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');

    // Panier et commandes
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Paiements
    Route::get('/payments/{order}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/download', [PaymentController::class, 'download'])->name('payments.download');
});

// Routes administrateur
Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pending-orders', [AdminController::class, 'pendingOrders'])->name('admin.pending-orders');
    Route::get('/admin/albums/create-test', function() {
        return view('admin.albums.create-test');
    })->name('admin.albums.create-test');
    Route::resource('/admin/albums', AdminController::class)->names('admin.albums');
    Route::post('/admin/payments/{payment}/approve', [AdminController::class, 'approvePayment'])->name('admin.payments.approve');
    Route::post('/admin/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('admin.payments.reject');
    Route::delete('/admin/tracks/{track}', [AdminController::class, 'destroyTrack'])->name('admin.tracks.destroy');
    Route::get('/admin/payments', [AdminController::class, 'paymentHistory'])->name('admin.payments.history');
});
