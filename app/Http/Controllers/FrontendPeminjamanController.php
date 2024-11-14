<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\DetailPeminjamanAlat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Anggota;
use App\Models\Bph;
use App\Models\PeminjamEksternal;

class FrontendPeminjamanController extends Controller
{
    // Tampilkan daftar alat yang tersedia
    public function index()
    {
        Log::info("Memuat halaman daftar alat.");

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
        Log::info("Memuat detail alat dengan ID: $id");

        $alat = Alat::findOrFail($id);
        return view('frontend-peminjaman.detail_alat', compact('alat'));
    }

    // Menambahkan alat ke keranjang
    public function addToCart(Request $request, $id)
    {
        Log::info("Menambahkan ke keranjang, ID alat: $id, Jumlah: " . $request->jumlah);

        $alat = Alat::findOrFail($id);

        if ($alat->jumlah_tersedia < $request->jumlah) {
            Log::warning("Jumlah alat yang diminta melebihi jumlah tersedia.");
            return response()->json(['success' => false, 'message' => 'Jumlah alat yang diminta melebihi jumlah tersedia.']);
        }

        $cart = session()->get('cart', []);
        $cart[$id] = [
            "id_alat" => $alat->id_alat,
            "name" => $alat->nama_alat,
            "jumlah" => $request->jumlah,
            "status" => $alat->status_alat,
            "foto" => $alat->foto,
        ];

        session()->put('cart', $cart);
        Log::info("Session cart setelah put: ", session()->get('cart'));
        Log::info("Keranjang setelah penambahan: ", $cart);

        return response()->json([
            'success' => true,
            'cartCount' => count($cart),
        ]);
    }

    // Tampilkan halaman keranjang peminjaman
    public function cart()
    {
        $cart = session()->get('cart', []);
        Log::info("Menampilkan isi keranjang: ", $cart);
        return view('frontend-peminjaman.cart', compact('cart'));
    }

    // Menghapus alat dari keranjang dengan AJAX
    public function removeFromCart($id)
    {
        Log::info("Menghapus item dari keranjang, ID alat: $id");

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        Log::info("Keranjang setelah penghapusan item: ", $cart);

        return response()->json([
            'success' => true,
            'message' => 'Alat berhasil dihapus dari keranjang!',
            'cartCount' => count($cart)
        ]);
    }

    // Update jumlah alat di keranjang
    public function updateCartQuantity(Request $request, $id)
    {
        Log::info("Memperbarui jumlah alat di keranjang, ID alat: $id, Aksi: " . $request->action);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $currentQty = $cart[$id]['jumlah'];
            if ($request->action === 'increment') {
                $cart[$id]['jumlah'] = $currentQty + 1;
            } elseif ($request->action === 'decrement' && $currentQty > 1) {
                $cart[$id]['jumlah'] = $currentQty - 1;
            }
            session()->put('cart', $cart);
        }

        Log::info("Keranjang setelah perubahan jumlah: ", $cart);

        return response()->json([
            'success' => true,
            'message' => 'Jumlah alat berhasil diperbarui!',
            'newQuantity' => $cart[$id]['jumlah'],
            'cartCount' => count($cart)
        ]);
    }

    // Simpan peminjaman alat ke dalam database
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        Log::info("Memproses checkout keranjang: ", $cart);

        foreach ($cart as $id => $details) {
            $alat = Alat::find($id);

            if ($alat->jumlah_tersedia < $details['jumlah']) {
                Log::warning("Jumlah alat yang diminta melebihi stok untuk ID: $id");
                return redirect()->route('alat.frontend.cart')->withErrors('Jumlah alat yang diminta melebihi jumlah yang tersedia.');
            }

            DetailPeminjamanAlat::create([
                'peminjamable_type' => Auth::user() instanceof Anggota ? 'App\Models\Anggota' : 'App\Models\PeminjamEksternal',
                'peminjamable_id' => Auth::id(),
                'id_alat' => $details['id_alat'],
                'id_inventaris' => '1',
                'id_persetujuan_ketum' => '1',
                'tanggal_pinjam' => now(),
                'kondisi_alat_dipinjam' => 'Baik',
                'jumlah_dipinjam' => $details['jumlah']
            ]);

            $alat->jumlah_tersedia -= $details['jumlah'];
            $alat->save();
        }

        session()->forget('cart');

        Log::info("Checkout berhasil, keranjang dikosongkan.");
        return redirect()->route('alat.frontend')->with('success', 'Peminjaman alat berhasil diproses!');
    }

    public function checkoutSelected(Request $request)
    {
        $selectedItems = $request->input('selectedItems', []);

        if (empty($selectedItems)) {
            return redirect()->route('alat.frontend.cart')->with('message', 'Tidak ada item yang dipilih untuk checkout.');
        }

        foreach ($selectedItems as $id) {
            $item = session('cart')[$id] ?? null;

            if ($item) {
                unset(session('cart')[$id]);
            }
        }

        session()->put('cart', session('cart'));

        return redirect()->route('alat.frontend.cart')->with('message', 'Checkout berhasil untuk item yang dipilih.');
    }
}
