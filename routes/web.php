<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ReportController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/switch-role', [AuthController::class, 'switchRole'])->name('switch-role');

// Shared Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [AnggotaController::class, 'profil'])->name('profil');
    Route::post('/profil', [AnggotaController::class, 'updateProfil'])->name('profil.update');
});

// Admin-Only Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // CRUD Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::get('/anggota/{id}', [AnggotaController::class, 'detail'])->name('anggota.detail');

    // Kelola Simpanan
    Route::get('/simpanan', [SimpananController::class, 'index'])->name('simpanan.index');
    Route::post('/simpanan', [SimpananController::class, 'store'])->name('simpanan.store');
    Route::get('/simpanan/{userId}', [SimpananController::class, 'detail'])->name('simpanan.detail');
    Route::delete('/simpanan/{id}', [SimpananController::class, 'destroy'])->name('simpanan.destroy');

    // Kelola Pinjaman
    Route::get('/pinjaman', [PinjamanController::class, 'index'])->name('pinjaman.index');
    Route::get('/pinjaman/{id}', [PinjamanController::class, 'detail'])->name('pinjaman.detail');
    Route::post('/pinjaman/{id}/approve', [PinjamanController::class, 'approveOrReject'])->name('pinjaman.approve');
    Route::post('/pinjaman/{id}/pay', [PinjamanController::class, 'payInstallment'])->name('pinjaman.pay');

    // Laporan
    Route::get('/laporan', [ReportController::class, 'laporan'])->name('laporan');
});

// Member (Anggota)-Only Routes
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'anggotaDashboard'])->name('dashboard');
    
    // Simpanan Saya
    Route::get('/simpanan', [SimpananController::class, 'anggotaSimpanan'])->name('simpanan');

    // Pinjaman Saya
    Route::get('/pinjaman', [PinjamanController::class, 'anggotaPinjaman'])->name('pinjaman.index');
    Route::get('/pinjaman/ajukan', [PinjamanController::class, 'formPengajuan'])->name('pinjaman.ajukan');
    Route::post('/pinjaman/ajukan', [PinjamanController::class, 'storePengajuan'])->name('pinjaman.store');
});
