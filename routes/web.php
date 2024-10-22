<?php

use Illuminate\Support\Facades\Route;

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
