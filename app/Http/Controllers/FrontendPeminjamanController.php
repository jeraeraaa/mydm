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
use App\Models\PersetujuanKetum;

class FrontendPeminjamanController extends Controller
{
    // Tampilkan daftar alat yang tersedia
    public function index(Request $request)
    {
        $selectedDivisi = $request->input('divisi', 'All');
        $alatQuery = Alat::query()->whereHas('bph', function ($query) {
            $query->where('nama_divisi_bph', '!=', 'inti');
        });

        if ($selectedDivisi !== 'All') {
            $alatQuery->where('id_bph', $selectedDivisi);
        }

        $alat = $alatQuery->paginate(8)->appends(['divisi' => $selectedDivisi]);
        $divisi = Bph::where('nama_divisi_bph', '!=', 'inti')->get();

        return view('frontend-peminjaman.alat', compact('alat', 'divisi', 'selectedDivisi'));
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
            "jumlah_tersedia" => $alat->jumlah_tersedia,
            "status" => $alat->status_alat,
            "foto" => $alat->foto,
        ];

        session()->put('cart', $cart);
        Log::info("Session cart setelah put: ", session()->get('cart'));

        return response()->json([
            'success' => true,
            'cartCount' => count($cart),
        ]);
    }

    // Tampilkan halaman keranjang
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

            Log::info("Keranjang setelah penghapusan item: ", $cart);
            return response()->json([
                'success' => true,
                'message' => 'Alat berhasil dihapus dari keranjang!',
                'cartCount' => count($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus item dari keranjang.'
        ], 400);
    }

    // Update jumlah alat di keranjang
    public function updateCartQuantity(Request $request, $id)
    {
        Log::info("Memperbarui jumlah alat di keranjang, ID alat: $id, Jumlah Baru: " . $request->quantity);

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] = $request->input('quantity'); // Gunakan jumlah dari input langsung
            session()->put('cart', $cart); // Simpan perubahan di session
        }

        Log::info("Keranjang setelah perubahan jumlah: ", $cart);

        return response()->json([
            'success' => true,
            'message' => 'Jumlah alat berhasil diperbarui!',
            'newQuantity' => $cart[$id]['jumlah'],
            'cartCount' => count($cart)
        ]);
    }


    // Menampilkan halaman konfirmasi peminjaman
    public function confirmLoan(Request $request)
    {
        $selectedItems = $request->input('selectedItems', []);

        if (empty($selectedItems)) {
            return redirect()->route('alat.frontend.cart')->with('message', 'Tidak ada item yang dipilih untuk checkout.');
        }

        $cart = session()->get('cart', []);
        $selectedCart = array_intersect_key($cart, array_flip($selectedItems));

        // Ambil data peminjam dari pengguna yang sedang login
        $peminjam = Auth::user(); // Pastikan guard auth mengarah ke model Anggota
        $peminjamData = [
            'nama' => $peminjam->nama_anggota,
            'nim' => $peminjam->id_anggota,
            'fakultas' => $peminjam->prodi->fakultas->nama_fakultas ?? 'Fakultas Tidak Diketahui',
            'jurusan' => $peminjam->prodi->nama_prodi ?? 'Jurusan Tidak Diketahui',
            'organisasi' => 'Internal Dharmayana',
        ];

        return view('frontend-peminjaman.confirm-loan', compact('selectedCart', 'peminjamData'));
    }


    // Generate nomor invoice
    private function generateInvoiceNumber($isEksternal)
    {
        $prefix = $isEksternal ? 'INV-E' : 'INV-I';
        $count = DetailPeminjamanAlat::count() + 1;
        return sprintf('%s-%03d', $prefix, $count);
    }

    // Simpan peminjaman alat ke dalam database
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        Log::info("Memproses peminjaman keranjang: ", $cart);

        // Buat satu entri persetujuan dengan id_ketum NULL
        $persetujuanKetum = PersetujuanKetum::create([
            'id_ketum' => null, // Biarkan NULL terlebih dahulu
            'status_persetujuan' => 'menunggu',
            'catatan' => null,
        ]);

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
                'id_inventaris' => null,
                'id_persetujuan_ketum' => $persetujuanKetum->id_persetujuan_ketum,
                'id_grup_peminjaman' => $persetujuanKetum->id_persetujuan_ketum,
                'tanggal_pinjam' => $request->input('tanggal_peminjaman'),
                'tanggal_kembali' => $request->input('tanggal_pengembalian'),
                'kondisi_alat_dipinjam' => 'Baik',
                'jumlah_dipinjam' => $details['jumlah']
            ]);

            $alat->jumlah_tersedia -= $details['jumlah'];
            $alat->save();
        }

        session()->forget('cart');
        Log::info("Checkout berhasil, keranjang dikosongkan.");

        // Redirect ke halaman konfirmasi
        return redirect()->route('alat.frontend.checkout-confirmation');
    }



    public function checkoutConfirmation()
    {
        return view('frontend-peminjaman.checkout-confirmation');
    }
}
