<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Rute Dashboard Utama (akan di-redirect oleh AuthController::redirectToDashboard)
    Route::get('/dashboard', [AuthController::class, 'redirectToDashboard'])->name('dashboard');

    // Rute Admin Panel
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        // Rute resource untuk Admin (misalnya, CustomerServiceController, PersonalTrainerController, PelangganController)
        // Pastikan Anda mengimport Controller-controller ini di bagian atas file
        // Contoh:
        // Route::resource('customer-service', App\Http\Controllers\CustomerServiceController::class);
        // Route::resource('personal-trainer', App\Http\Controllers\PersonalTrainerController::class);
        // Route::resource('pelanggan', App\Http\Controllers\PelangganController::class);
        // Route::resource('kartu', App\Http\Controllers\KartuController::class)->except(['create', 'store']);
        // Route::resource('catatan', App\Http\Controllers\CatatanController::class)->except(['create', 'store']);
    });

    // Rute Customer Service Panel
    Route::prefix('cs')->name('cs.')->group(function () {
        Route::get('/dashboard', function () { return view('cs.dashboard'); })->name('dashboard');
        // Rute resource untuk CS
        // Contoh:
        // Route::resource('personal-trainer', App\Http\Controllers\PersonalTrainerController::class)->except(['show', 'destroy']);
        // Route::resource('pelanggan', App\Http\Controllers\PelangganController::class)->except(['destroy']);
    });

    // Rute Personal Trainer Panel
    Route::prefix('trainer')->name('trainer.')->group(function () {
        Route::get('/dashboard', function () { return view('trainer.dashboard'); })->name('dashboard');
        // Rute resource untuk Trainer
        // Contoh:
        // Route::resource('kartu', App\Http\Controllers\KartuController::class);
        // Route::get('pelanggan', [App\Http\Controllers\PelangganController::class, 'index'])->name('pelanggan.index');
        // Route::get('pelanggan/{pelanggan}', [App\Http\Controllers\PelangganController::class, 'show'])->name('pelanggan.show');
    });

    // Rute Pelanggan Panel
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/dashboard', function () { return view('pelanggan.dashboard'); })->name('dashboard');
        // Rute resource untuk Pelanggan
        // Contoh:
        // Route::resource('catatan', App\Http\Controllers\CatatanController::class);
        // Route::get('kartu', [App\Http\Controllers\KartuController::class, 'indexForPelanggan'])->name('kartu.index');
        // Route::get('/profile', [App\Http\Controllers\PelangganController::class, 'show'])->name('profile.show');
        // Route::get('/profile/edit', [App\Http\Controllers\PelangganController::class, 'edit'])->name('profile.edit');
        // Route::patch('/profile', [App\Http\Controllers\PelangganController::class, 'update'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';    