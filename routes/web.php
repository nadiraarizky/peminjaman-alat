<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

// ================= WELCOME =================
Route::get('/', function () {
    return view('welcome');
});

// ================= HOME (redirect by role) =================
Route::get('/home', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'user') {
        return redirect()->route('user.dashboard');
    }

    return redirect('/');
})->middleware('auth')->name('home');

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('alats', AlatController::class);

        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });

// ================= USER =================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/peminjaman', [UserDashboardController::class, 'peminjaman'])
            ->name('peminjaman');

        Route::get('/account', function () {
            return view('user.account');
        })->name('account');
    });

// ================= PROFILE =================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= AUTH (WAJIB ADA) =================
require __DIR__.'/auth.php';
