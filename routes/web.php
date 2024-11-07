<?php

use App\Http\Controllers\AlatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KegiatanController;

use App\Http\Controllers\FrontendAlatController;
use App\Http\Controllers\BackendAlatController;
use App\Http\Controllers\BackendAnggotaController;
use App\Http\Controllers\BackendKegiatanController;
use App\Http\Controllers\DashboardController;

// Halaman home dan halaman statis lainnya
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

Route::get('/kegiatan', function () {
    return view('kegiatan', ['title' => 'Kegiatan']);
});

// Rute frontend yang dapat diakses oleh anggota setelah login
Route::group(['middleware' => ['auth']], function () {
    Route::get('/alat', [FrontendAlatController::class, 'index'])->name('alat.frontend');
    Route::get('/pengajuan', function () {
        return view('pengajuan');
    });
    Route::get('/profil', function () {
        return view('profil');
    });
});

// Authentication Routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetController::class, 'sendEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

// Rute backend yang hanya dapat diakses oleh admin dan super user
Route::group(['middleware' => ['auth', 'checkRole:admin,superuser']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('user-management', function () {
        return view('laravel-examples/user-management');
    })->name('user-management');

    Route::resource('anggota', AnggotaController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('alat', AlatController::class);

    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);

    // Route untuk logout setelah login
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});


// // // Ini akan mengaktifkan semua route autentikasi default Laravel (login, register, reset password, dll.)
// Auth::routes();
