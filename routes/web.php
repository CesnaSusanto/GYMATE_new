<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PersonalTrainerController;
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
        Route::get('/dashboard', [CustomerServiceController::class, 'showManagementLists'])->name('dashboard'); // <-- Ini nama rutenya adalah 'cs.dashboard'

        // Rute untuk mengelola Member (Pelanggan)
        Route::get('/members/{id}/edit', [CustomerServiceController::class, 'editMember'])->name('members.edit');
        Route::put('/members/{id}', [CustomerServiceController::class, 'updateMember'])->name('members.update');
        Route::delete('/members/{id}', [CustomerServiceController::class, 'deleteMember'])->name('members.destroy');

        // Rute BARU untuk menambah Personal Trainer
        Route::get('/trainer/create', [CustomerServiceController::class, 'createTrainer'])->name('trainer.create');
        Route::post('/trainer', [CustomerServiceController::class, 'storeTrainer'])->name('trainer.store');

        // Rute untuk mengelola Personal Trainer yang sudah ada
        Route::get('/trainer/{id}/edit', [CustomerServiceController::class, 'editTrainer'])->name('trainer.edit');
        Route::put('/trainer/{id}', [CustomerServiceController::class, 'updateTrainer'])->name('trainer.update');
        Route::delete('/trainer/{id}', [CustomerServiceController::class, 'deleteTrainer'])->name('trainer.destroy');
    });

    // Rute Personal Trainer Panel
    Route::prefix('trainer')->name('trainer.')->group(function () {
        // Dashboard Personal Trainer
        Route::get('/dashboard', [PersonalTrainerController::class, 'dashboard'])->name('dashboard');

        // Rute untuk melihat jadwal member.
        // Nama rutenya akan menjadi 'trainer.show_jadwal'
        // Menggunakan {pelanggan} untuk Route Model Binding ke model Pelanggan
        Route::get('/jadwal/create/{pelanggan?}', [KartuController::class, 'createJadwal'])->name('jadwal.create');
        Route::get('/member/{pelanggan}/jadwal', [KartuController::class, 'showJadwal'])->name('show_jadwal');

        // Rute untuk menyimpan catatan sesi latihan untuk pelanggan.
        // Nama rutenya akan menjadi 'trainer.jadwal.store'
        // Route::post('/jadwal/create', [App\Http\Controllers\PersonalTrainerController::class, 'createJadwal'])->name('jadwal.create');
        Route::post('/member/jadwal/store', [KartuController::class, 'storeJadwal'])->name('jadwal.store');
        Route::get('/member/jadwal/{kartu}/edit', [KartuController::class, 'editJadwal'])->name('jadwal.edit');
        Route::put('/member/jadwal/{kartu}', [KartuController::class, 'updateJadwal'])->name('jadwal.update');
        Route::delete('/member/jadwal/{kartu}', [KartuController::class, 'destroyJadwal'])->name('jadwal.destroy');
    
    });
    // Rute Pelanggan Panel
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('dashboard');

        // Rute untuk Catatan Latihan
        
    Route::post('/catatan/create', [CatatanController::class, 'storeCatatan'])->name('catatan.store');
    Route::get('/catatan/create', [CatatanController::class, 'createCatatan'])->name('catatan.create');
    Route::get('/catatan/{catatan}/edit', [CatatanController::class, 'editCatatan'])->name('catatan.edit'); // Anda perlu membuat view ini
    Route::put('/catatan/{catatan}', [CatatanController::class, 'updateCatatan'])->name('catatan.update');
    Route::delete('/catatan/{catatan}', [CatatanController::class, 'destroyCatatan'])->name('catatan.destroy');
    Route::get('/jadwal/{kartu}', [PelangganController::class, 'showJadwalDetail'])->name('jadwal.show'); // <--- TAMBAHKAN INI


    
        
    
    });
});


require __DIR__.'/auth.php';    