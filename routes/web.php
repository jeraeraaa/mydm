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
use App\Http\Controllers\UserController;
use App\Http\Controllers\KetuaUmumController;
use App\Http\Controllers\InventarisController;

// Import Controller di BackendKegiatan
use App\Http\Controllers\BackendKegiatan\KategoriKegiatanController;
use App\Http\Controllers\BackendKegiatan\KegiatanController;
use App\Http\Controllers\BackendKegiatan\MateriController;
use App\Http\Controllers\BackendKegiatan\PembicaraController;
use App\Http\Controllers\BackendKegiatan\DetailKegiatanController;
use App\Http\Controllers\FrontendPeminjamanController;

use App\Http\Controllers\BackendAlat\PersetujuanKetumController;
use App\Http\Controllers\BackendAlat\StatusController;
use App\Http\Controllers\BackendAlat\PengembalianController;
use App\Http\Controllers\FrontendKegiatanController;

// Halaman home dan halaman statis lainnya
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

Route::get('/frontend-kegiatan', [FrontendKegiatanController::class, 'index'])->name('frontend-kegiatan.index');
Route::get('/frontend-kegiatan/{id}', [FrontendKegiatanController::class, 'show'])->name('frontend-kegiatan.show');


Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
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
    Route::post('/frontend-peminjaman/alat/update-quantity/{id}', [FrontendPeminjamanController::class, 'updateCartQuantity'])->name('alat.frontend.updateCartQuantity');
    // Mengubah route menjadi POST untuk menghindari error DELETE
    Route::post('/frontend-peminjaman/cart/remove/{id}', [FrontendPeminjamanController::class, 'removeFromCart'])->name('alat.frontend.removeFromCart');
    // Route baru untuk mengajukan peminjaman setelah checkout
    Route::post('/frontend-peminjaman/confirm-loan', [FrontendPeminjamanController::class, 'confirmLoan'])->name('alat.frontend.confirmLoan');
    // Route untuk checkout final setelah konfirmasi
    Route::post('/frontend-peminjaman/checkout', [FrontendPeminjamanController::class, 'checkout'])->name('alat.frontend.checkout');
    Route::get('/frontend-peminjaman/checkout-confirmation', [FrontendPeminjamanController::class, 'checkoutConfirmation'])->name('alat.frontend.checkout-confirmation');

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/role', [UserController::class, 'index'])->name('role.index');
    Route::put('/role/{id}', [UserController::class, 'updateRole'])->name('role.update');
    Route::post('/role', [UserController::class, 'createUser'])->name('role.create');
    Route::delete('/role/{id}', [UserController::class, 'deleteUser'])->name('role.delete');
    Route::get('/role/check-nim', [UserController::class, 'checkNim'])->name('role.checkNim');


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

    //Route untuk ketum dan inventaris
    Route::resource('ketua-umum', KetuaUmumController::class);
    Route::resource('inventaris', InventarisController::class);


    Route::get('backend-alat/persetujuan', [PersetujuanKetumController::class, 'index'])->name('persetujuan.index');
    Route::get('backend-alat/persetujuan/{id}', [PersetujuanKetumController::class, 'show'])->name('persetujuan.show');
    Route::post('backend-alat/persetujuan/{id}/approve', [PersetujuanKetumController::class, 'approve'])->name('persetujuan.approve');
    Route::post('backend-alat/persetujuan/{id}/reject', [PersetujuanKetumController::class, 'reject'])->name('persetujuan.reject');

    Route::prefix('backend-alat/status-peminjaman')->group(function () {
        Route::get('/', [StatusController::class, 'index'])->name('status-peminjaman.index');
        Route::get('/{id}', [StatusController::class, 'show'])->name('status-peminjaman.show');
        Route::post('/{id}/update', [StatusController::class, 'updateStatus'])->name('status-peminjaman.update');
    });

    Route::get('backend-alat/pengembalian-alat/{id}', [PengembalianController::class, 'create'])->name('pengembalian-alat.create');
    Route::post('backend-alat/pengembalian-alat/{id}', [PengembalianController::class, 'store'])->name('pengembalian-alat.store');
});


// Route untuk logout setelah login
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
