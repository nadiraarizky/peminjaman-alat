<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;

// Import Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\LogController; 
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PeminjamanManagementController;

// Import User Controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\AlatController as UserAlatController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;

// ================= WELCOME =================
Route::get('/', function () {
    return view('welcome');
});

// ================= HOME (Redirect by Role) =================
Route::get('/home', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'user') {
        return redirect()->route('user.dashboard');
    }
    return redirect('/');
})->middleware('auth')->name('home');

// ================= ADMIN AREA =================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth']) 
    ->group(function () {
        
        // Dashboard Admin
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD Alat
        Route::prefix('alats')->name('alats.')->group(function () {
            Route::get('/', [AlatController::class, 'index'])->name('index');
            Route::get('/create', [AlatController::class, 'create'])->name('create');
            Route::post('/store', [AlatController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AlatController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AlatController::class, 'update'])->name('update');
            Route::delete('/{id}', [AlatController::class, 'destroy'])->name('destroy');
        });

        // CRUD KATEGORI
        Route::prefix('kategoris')->name('kategoris.')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('index');
            Route::post('/store', [KategoriController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
        });

        // CRUD USER
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // LOG AKTIVITAS (SUDAH DIPERBAIKI)
        Route::prefix('logs')->name('logs.')->group(function () {
            Route::get('/', [LogController::class, 'index'])->name('index');
            Route::get('/export-pdf', [LogController::class, 'exportPDF'])->name('exportPDF');
            Route::delete('/destroy-all', [LogController::class, 'destroyAll'])->name('destroyAll');
        });

        // MANAJEMEN DATA PEMINJAMAN (Persetujuan & Riwayat)
        Route::prefix('peminjamans')->name('peminjamans.')->group(function () {
            Route::get('/', [AdminPeminjamanController::class, 'index'])->name('index');
            Route::patch('/{id}/setujui', [AdminPeminjamanController::class, 'approve'])->name('approve');
            Route::patch('/{id}/tolak', [AdminPeminjamanController::class, 'reject'])->name('reject');
            Route::get('/history', [AdminPeminjamanController::class, 'history'])->name('history');
            Route::get('/export-pdf', [PeminjamanManagementController::class, 'exportPDF'])->name('exportPDF');
        });
    });

// ================= USER AREA =================
Route::prefix('user')
    ->name('user.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/alats', [UserAlatController::class, 'index'])->name('alats.index');

        // PROSES PINJAM & RIWAYAT
        Route::prefix('pinjam')->name('pinjam.')->group(function () {
            Route::get('/create', [UserPeminjamanController::class, 'create'])->name('create');
            Route::post('/store', [UserPeminjamanController::class, 'store'])->name('store');
            Route::get('/index', [UserPeminjamanController::class, 'index'])->name('index');
            Route::get('/history', [UserPeminjamanController::class, 'history'])->name('history');
            Route::patch('/{id}/return', [UserPeminjamanController::class, 'returnBack'])->name('return');
        });
    });

// ================= PROFILE & AUTH =================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';