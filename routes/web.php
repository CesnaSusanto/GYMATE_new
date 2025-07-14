<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


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
    });

    // Rute Customer Service Panel
    Route::prefix('cs')->name('cs.')->group(function () {
        Route::get('/dashboard', [CustomerServiceController::class, 'showManagementLists'])->name('dashboard');

        Route::get('/dashboard/members/{id}/edit', [CustomerServiceController::class, 'editMember'])->name('members.edit'); // Nama route menjadi 'cs.members.edit'
        Route::put('/dashboard/members/{id}', [CustomerServiceController::class, 'updateMember'])->name('members.update');   // Nama route menjadi 'cs.members.update'
        Route::delete('/dashboard/members/{id}', [CustomerServiceController::class, 'deleteMember'])->name('members.destroy');

        Route::get('/dashboard/trainer/{id}/edit', [CustomerServiceController::class, 'editTrainer'])->name('trainer.edit'); // Nama route menjadi 'cs.trainer.edit'
        Route::put('/dashboard/trainer/{id}', [CustomerServiceController::class, 'updateTrainer'])->name('trainer.update');   // Nama route menjadi 'cs.trainer.update'
        Route::delete('/dashboard/trainer/{id}', [CustomerServiceController::class, 'deleteTrainer'])->name('trainer.destroy');

    });

    // Rute Personal Trainer Panel
    Route::prefix('trainer')->name('trainer.')->group(function () {
        Route::get('/dashboard', function () { return view('trainer.dashboard'); })->name('dashboard');
    });

    // Rute Pelanggan Panel
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/dashboard', function () { return view('pelanggan.dashboard'); })->name('dashboard');
    });
});

require __DIR__.'/auth.php';    