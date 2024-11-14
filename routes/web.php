<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;

// Import Controller di BackendKegiatan
use App\Http\Controllers\BackendKegiatan\KategoriKegiatanController;
use App\Http\Controllers\BackendKegiatan\KegiatanController;
use App\Http\Controllers\BackendKegiatan\MateriController;
use App\Http\Controllers\BackendKegiatan\PembicaraController;
use App\Http\Controllers\BackendKegiatan\DetailKegiatanController;
use App\Http\Controllers\FrontendPeminjamanController;

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

//Rute backend yang hanya dapat diakses oleh admin dan super user
Route::group(['middleware' => 'auth'], function () {

    //Alat Anggota
    Route::get('/frontend-peminjaman/alat', [FrontendPeminjamanController::class, 'index'])->name('alat.frontend');
    Route::get('/frontend-peminjaman/alat/{id}', [FrontendPeminjamanController::class, 'show'])->name('alat.frontend.show');
    Route::get('/frontend-peminjaman/cart', [FrontendPeminjamanController::class, 'cart'])->name('alat.frontend.cart');
    Route::post('/frontend-peminjaman/alat/add/{id}', [FrontendPeminjamanController::class, 'addToCart'])->name('alat.frontend.addToCart');
    Route::delete('/frontend-peminjaman/cart/remove/{id}', [FrontendPeminjamanController::class, 'removeFromCart'])->name('alat.frontend.removeFromCart');

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('user-management', function () {
        return view('laravel-examples/user-management');
    })->name('user-management');

    // Resource untuk Anggota dan Alat
    Route::resource('anggota', AnggotaController::class);
    Route::resource('alat', AlatController::class);

    // Resource routes untuk controller di BackendKegiatan
    Route::resource('kategori-kegiatan', KategoriKegiatanController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('detail-kegiatan', DetailKegiatanController::class);
    Route::resource('materi', MateriController::class);
    Route::resource('pembicara', PembicaraController::class);

    // Route untuk user profile
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
});

// Route untuk logout setelah login
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
