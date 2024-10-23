<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

// Halaman statis
Route::get('/', function () {
    return view('home');
});

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

//authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');