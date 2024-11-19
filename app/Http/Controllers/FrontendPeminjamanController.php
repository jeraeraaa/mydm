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
use App\Models\ProgramStudi;

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

        // Ambil data alat beserta relasi ke detail peminjaman dengan filter status 'disetujui'
        $alat = Alat::with([
            'detailPeminjaman' => function ($query) {
                $query->whereHas('persetujuanKetum', function ($q) {
                    $q->where('status_persetujuan', 'disetujui');
                });
            },
            'detailPeminjaman.peminjamable',
        ])->findOrFail($id);

        // Tambahkan informasi nama peminjam ke setiap detail peminjaman
        foreach ($alat->detailPeminjaman as $peminjaman) {
            // Polymorphic relation untuk mendapatkan nama peminjam
            if ($peminjaman->peminjamable_type === \App\Models\Anggota::class) {
                $peminjaman->nama_peminjam = $peminjaman->peminjamable->nama_anggota ?? 'Tidak Diketahui';
            } elseif ($peminjaman->peminjamable_type === \App\Models\PeminjamEksternal::class) {
                $peminjaman->nama_peminjam = $peminjaman->peminjamable->nama ?? 'Tidak Diketahui';
            } else {
                $peminjaman->nama_peminjam = 'Tidak Diketahui';
            }
        }

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

        if (empty($selectedCart)) {
            // Jika tidak ada data yang valid di session, kembalikan ke keranjang
            return redirect()->route('alat.frontend.cart')->with('message', 'Data keranjang tidak valid.');
        }
        // Ambil data jenis peminjam (pribadi atau eksternal) dari request
        $jenisPeminjam = $request->input('jenis_peminjam', 'pribadi');

        if ($jenisPeminjam === 'pribadi') {
            // Jika peminjam adalah pribadi (anggota), gunakan data dari pengguna yang sedang login
            $peminjam = Auth::user(); // Pastikan guard auth mengarah ke model Anggota
            $peminjamData = [
                'nama' => $peminjam->nama_anggota,
                'nim' => $peminjam->id_anggota,
                'fakultas' => $peminjam->prodi->fakultas->nama_fakultas ?? 'Fakultas Tidak Diketahui',
                'jurusan' => $peminjam->prodi->nama_prodi ?? 'Jurusan Tidak Diketahui',
                'organisasi' => 'Internal Dharmayana',
            ];
        } elseif ($jenisPeminjam === 'eksternal') {
            // Jika peminjam adalah eksternal, ambil data dari input form
            $validated = $request->validate([
                'nama_eksternal' => 'required|string|max:255',
                'id_eksternal' => 'required|string|max:10|unique:peminjam_eksternal,id_peminjam_eksternal',
                'organisasi_eksternal' => 'required|string|max:255',
            ]);

            $peminjamData = [
                'nama' => $validated['nama_eksternal'],
                'nim' => $validated['id_eksternal'],
                'fakultas' => 'Eksternal',
                'jurusan' => 'Eksternal',
                'organisasi' => $validated['organisasi_eksternal'],
            ];

            // Simpan data ke tabel `peminjam_eksternal`
            \App\Models\PeminjamEksternal::create([
                'id_peminjam_eksternal' => $validated['id_eksternal'],
                'id_prodi' => $request->input('id_prodi', '000'), // Default ID Prodi jika tidak tersedia
                'nama' => $validated['nama_eksternal'],
                'organisasi' => $validated['organisasi_eksternal'],
            ]);
        } else {
            return redirect()->route('alat.frontend.cart')->with('error', 'Jenis peminjam tidak valid.');
        }

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
        $cart = session()->get('cart', []); // Ambil data keranjang dari sesi

        Log::info("Memproses peminjaman keranjang: ", $cart);

        // Validasi input tanggal dan jenis peminjam
        $validatedData = $request->validate([
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
            'jenis_peminjam' => 'required|in:pribadi,eksternal',
        ]);

        // Pastikan keranjang tidak kosong
        if (empty($cart)) {
            return redirect()->route('alat.frontend.cart')->with('error', 'Keranjang Anda kosong.');
        }

        // Buat persetujuan ketum
        $persetujuanKetum = PersetujuanKetum::create([
            'id_ketum' => null, // Biarkan null sampai disetujui
            'status_persetujuan' => 'menunggu',
            'catatan' => null,
        ]);

        // Jenis peminjam: pribadi atau eksternal
        $jenisPeminjam = $validatedData['jenis_peminjam'];

        try {
            foreach ($cart as $id => $details) {
                $alat = Alat::find($id);

                // Validasi ketersediaan alat
                if (!$alat) {
                    throw new \Exception("Alat dengan ID $id tidak ditemukan.");
                }

                if ($alat->jumlah_tersedia < $details['jumlah']) {
                    throw new \Exception("Jumlah alat dengan ID $id tidak mencukupi.");
                }

                if ($jenisPeminjam === 'pribadi') {
                    // Jika jenis peminjam adalah anggota
                    DetailPeminjamanAlat::create([
                        'peminjamable_type' => Anggota::class,
                        'peminjamable_id' => Auth::id(),
                        'id_alat' => $details['id_alat'],
                        'id_inventaris' => null,
                        'id_persetujuan_ketum' => $persetujuanKetum->id_persetujuan_ketum,
                        'id_grup_peminjaman' => $persetujuanKetum->id_persetujuan_ketum,
                        'tanggal_pinjam' => $validatedData['tanggal_peminjaman'],
                        'tanggal_kembali' => $validatedData['tanggal_pengembalian'],
                        'kondisi_alat_dipinjam' => 'Baik',
                        'jumlah_dipinjam' => $details['jumlah'],
                    ]);
                } elseif ($jenisPeminjam === 'eksternal') {
                    // Validasi data eksternal
                    $validatedEksternal = $request->validate([
                        'id_eksternal' => 'required|string|max:10',
                        'nama_eksternal' => 'required|string|max:255',
                        'organisasi_eksternal' => 'required|string|max:255',
                    ]);

                    // Ambil kode prodi dari 3 digit pertama ID peminjam
                    $kodeProdi = substr($validatedEksternal['id_eksternal'], 0, 3);

                    // Validasi program studi
                    $prodi = ProgramStudi::where('id_prodi', $kodeProdi)->first();
                    if (!$prodi) {
                        throw new \Exception("Kode prodi tidak valid untuk NIM {$validatedEksternal['id_eksternal']}.");
                    }

                    // Periksa apakah peminjam eksternal sudah ada di database
                    $peminjamEksternal = PeminjamEksternal::where('id_peminjam_eksternal', $validatedEksternal['id_eksternal'])->first();

                    if (!$peminjamEksternal) {
                        // Jika belum ada, buat entri baru
                        $peminjamEksternal = PeminjamEksternal::create([
                            'id_peminjam_eksternal' => $validatedEksternal['id_eksternal'], // NIM yang diinput
                            'nama' => $validatedEksternal['nama_eksternal'],
                            'organisasi' => $validatedEksternal['organisasi_eksternal'],
                            'id_prodi' => $prodi->id_prodi, // 3 digit pertama sebagai id_prodi
                        ]);
                    }

                    // Buat detail peminjaman
                    DetailPeminjamanAlat::create([
                        'peminjamable_type' => PeminjamEksternal::class,
                        'peminjamable_id' => $peminjamEksternal->id_peminjam_eksternal,
                        'id_alat' => $details['id_alat'],
                        'id_inventaris' => null,
                        'id_persetujuan_ketum' => $persetujuanKetum->id_persetujuan_ketum,
                        'id_grup_peminjaman' => $persetujuanKetum->id_persetujuan_ketum,
                        'tanggal_pinjam' => $validatedData['tanggal_peminjaman'],
                        'tanggal_kembali' => $validatedData['tanggal_pengembalian'],
                        'kondisi_alat_dipinjam' => 'Baik',
                        'jumlah_dipinjam' => $details['jumlah'],
                    ]);
                }

                // Update jumlah alat tersedia
                $alat->decrement('jumlah_tersedia', $details['jumlah']);
            }

            // Kosongkan keranjang setelah sukses
            session()->forget('cart');

            Log::info("Checkout berhasil, keranjang dikosongkan.");
            return redirect()->route('alat.frontend.checkout-confirmation');
        } catch (\Exception $e) {
            Log::error("Error saat checkout: " . $e->getMessage());
            return redirect()->route('alat.frontend.cart')->with('error', $e->getMessage());
        }
    }







    public function checkoutConfirmation()
    {
        return view('frontend-peminjaman.checkout-confirmation');
    }
}
