<?php

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

Route::get('/anggota', function () {
    return view('anggota', ['title' => 'Anggota']);
});

Route::get('/alat', function () {
    return view('alat', ['title' => 'Alat']);
});

Route::get('/pengajuan', function () {
    return view('pengajuan');
});

Route::get('/profil', function () {
    return view('profil');
});

// Authentication Routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

// Route untuk logout setelah login
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Dashboard dan halaman lain yang membutuhkan autentikasi
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('billing', function () {
        return view('billing');
    })->name('billing');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('user-management', function () {
        return view('laravel-examples/user-management');
    })->name('user-management');

    Route::get('member-management', function () {
        return view('laravel-examples/member-management');
    })->name('member-management');

    Route::get('tables', function () {
        return view('tables');
    })->name('tables');

    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
});

// Ini akan mengaktifkan semua route autentikasi default Laravel (login, register, reset password, dll.)
Auth::routes();
