<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\DetailPeminjamanAlat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Anggota;
use App\Models\Bph;
use App\Models\PeminjamEksternal;

class FrontendPeminjamanController extends Controller
{
    // Tampilkan daftar alat yang tersedia
    public function index()
    {
        $alat = Alat::where('status_alat', 'A')
            ->whereHas('bph', function ($query) {
                $query->where('nama_divisi_bph', '!=', 'inti');
            })
            ->paginate(8); 

        // Mengambil semua divisi kecuali "inti" untuk filter divisi
        $divisi = Bph::where('nama_divisi_bph', '!=', 'inti')->get();

        return view('frontend-peminjaman.alat', compact('alat', 'divisi'));
    }

    // Menampilkan detail alat tertentu
    public function show($id)
    {
        $alat = Alat::findOrFail($id); // Menemukan alat berdasarkan ID
        return view('frontend-peminjaman.detail_alat', compact('alat'));
    }

    // Menambahkan alat ke keranjang
    public function addToCart(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        if ($alat->jumlah_tersedia < $request->jumlah) {
            return redirect()->back()->withErrors('Jumlah alat yang diminta melebihi jumlah tersedia.');
        }

        // Simpan alat dalam session 'cart' dengan data tambahan
        $cart = session()->get('cart', []);
        $cart[$id] = [
            "id_alat" => $alat->id_alat,
            "name" => $alat->nama_alat,
            "jumlah" => $request->jumlah,
            "status" => $alat->status_alat
        ];

        session()->put('cart', $cart);
        return redirect()->route('alat.frontend')->with('success', 'Alat berhasil ditambahkan ke keranjang!');
    }

    // Tampilkan halaman keranjang peminjaman
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('frontend-peminjaman.cart', compact('cart'));
    }

    // Menghapus alat dari keranjang
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('alat.frontend.cart')->with('success', 'Alat berhasil dihapus dari keranjang!');
    }

    // Simpan peminjaman alat ke dalam database
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $id => $details) {
            DetailPeminjamanAlat::create([
                'peminjamable_type' => Auth::user() instanceof Anggota ? 'App\Models\Anggota' : 'App\Models\PeminjamEksternal',
                'peminjamable_id' => Auth::id(),
                'id_alat' => $details['id_alat'],
                'id_inventaris' => '1', // id inventaris default (disesuaikan)
                'id_persetujuan_ketum' => '1', // id persetujuan default (disesuaikan)
                'tanggal_pinjam' => now(),
                'kondisi_alat_dipinjam' => 'Baik',
                'jumlah_dipinjam' => $details['jumlah']
            ]);

            // Kurangi jumlah alat yang tersedia
            $alat = Alat::find($id);
            $alat->jumlah_tersedia -= $details['jumlah'];
            $alat->save();
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('alat.frontend')->with('success', 'Peminjaman alat berhasil diproses!');
    }
}
