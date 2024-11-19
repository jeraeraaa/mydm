<?php

namespace App\Http\Controllers\BackendKegiatan;

use App\Http\Controllers\Controller;
use App\Models\Pembicara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembicaraController extends Controller
{
    // Menampilkan daftar pembicara
    public function index()
    {
        try {
            $pembicara = Pembicara::all();
            return view('backend-kegiatan.pembicara.index', compact('pembicara'));
        } catch (\Exception $e) {
            Log::error("Gagal menampilkan daftar pembicara: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menampilkan daftar pembicara.']);
        }
    }

    // Menyimpan pembicara baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembicara' => 'required|string|max:255',
            'kontak_pembicara' => 'required|digits_between:10,15', // Hanya angka, minimal 10 dan maksimal 15 digit
        ]);

        try {
            Pembicara::create([
                'nama_pembicara' => $request->nama_pembicara,
                'kontak_pembicara' => $request->kontak_pembicara,
            ]);

            Log::info("Pembicara berhasil ditambahkan: " . $request->nama_pembicara);
            return redirect()->route('pembicara.index')->with('success', 'Pembicara berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Gagal menambahkan pembicara: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menambahkan pembicara.'])->withInput();
        }
    }

    // Menampilkan form edit pembicara
    public function edit($id)
    {
        try {
            $pembicara = Pembicara::findOrFail($id);
            return view('backend-kegiatan.pembicara.edit', compact('pembicara'));
        } catch (\Exception $e) {
            Log::error("Gagal menampilkan form edit pembicara: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menampilkan form edit pembicara.']);
        }
    }

    // Memperbarui pembicara yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembicara' => 'required|string|max:255', // Hanya huruf dan spasi
            'kontak_pembicara' => 'required|digits_between:10,15', // Hanya angka, minimal 10 dan maksimal 15 digit
        ]);

        try {
            $pembicara = Pembicara::findOrFail($id);
            $pembicara->update([
                'nama_pembicara' => $request->nama_pembicara,
                'kontak_pembicara' => $request->kontak_pembicara,
            ]);

            Log::info("Pembicara ID {$id} berhasil diperbarui.");
            return redirect()->route('pembicara.index')->with('success', 'Pembicara berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui pembicara: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui pembicara.'])->withInput();
        }
    }

    // Menghapus pembicara
    public function destroy($id)
    {
        try {
            $pembicara = Pembicara::findOrFail($id);
            $pembicara->delete();

            Log::info("Pembicara ID {$id} berhasil dihapus.");
            return redirect()->route('pembicara.index')->with('success', 'Pembicara berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus pembicara: " . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus pembicara.']);
        }
    }
}
