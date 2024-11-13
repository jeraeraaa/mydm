<?php

namespace App\Http\Controllers\BackendKegiatan;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\DetailKegiatan;
use App\Models\Pembicara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MateriController extends Controller
{
    // Display a listing of the materi
    public function index(Request $request)
    {
        Log::info('Index Request Data: ', $request->all());

        try {
            $detailKegiatanList = DetailKegiatan::all();
            $pembicaraList = Pembicara::all();

            $query = Materi::with(['detailKegiatan', 'pembicara']);

            if ($request->has('pembicara_filter') && $request->pembicara_filter) {
                $query->where('id_pembicara', $request->pembicara_filter);
                Log::info('Filter applied on pembicara_filter: ' . $request->pembicara_filter);
            }

            $materi = $query->get();

            Log::info('Materi data retrieved: ', $materi->toArray());

            return view('backend-kegiatan.materi.index', compact('materi', 'detailKegiatanList', 'pembicaraList'));
        } catch (\Exception $e) {
            Log::error("Failed to display materi list: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to display materi list.']);
        }
    }

    // Show the form for creating a new materi
    public function create()
    {
        $detailKegiatanList = DetailKegiatan::all();
        $pembicaraList = Pembicara::all();
        return view('backend-kegiatan.materi.create', compact('detailKegiatanList', 'pembicaraList'));
    }

    public function store(Request $request)
    {
        // Validasi untuk memastikan id_detail_kegiatan dan id_pembicara ada dalam request
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'deskripsi_materi' => 'nullable|string',
            'id_detail_kegiatan' => 'required|exists:detail_kegiatan,id_detail_kegiatan',
            'id_pembicara' => 'nullable|exists:pembicara,id_pembicara',
        ]);

        try {
            // Log data request untuk memastikan input
            Log::info('Store Request Data (after validation): ', $request->all());

            // Explicitly retrieve and log values
            $data = $request->only(['nama_materi', 'deskripsi_materi', 'id_detail_kegiatan', 'id_pembicara']);
            Log::info('Data for Insertion: ', $data);

            // Menyimpan data materi
            Materi::create($data);

            Log::info('Materi successfully added');
            return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error("Failed to add materi: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add materi.'])->withInput();
        }
    }


    // Show the form for editing the specified materi
    public function edit($id)
    {
        Log::info("Edit Request for Materi ID: $id");

        $materi = Materi::findOrFail($id);
        $detailKegiatanList = DetailKegiatan::all();
        $pembicaraList = Pembicara::all();

        Log::info('Materi Data for Edit: ', $materi->toArray());

        return view('backend-kegiatan.materi.edit', compact('materi', 'detailKegiatanList', 'pembicaraList'));
    }

    // Update the specified materi in storage
    public function update(Request $request, $id)
    {
        Log::info("Update Request for Materi ID: $id", $request->all());

        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'deskripsi_materi' => 'nullable|string',
            'id_detail_kegiatan' => 'required|exists:detail_kegiatan,id_detail_kegiatan',
            'id_pembicara' => 'required|exists:pembicara,id_pembicara',
        ]);

        try {
            $materi = Materi::findOrFail($id);
            Log::info('Current Materi Data before Update: ', $materi->toArray());

            $materi->update($request->all());
            Log::info("Materi ID $id successfully updated");

            return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error("Failed to update materi: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update materi.'])->withInput();
        }
    }

    // Remove the specified materi from storage
    public function destroy($id)
    {
        Log::info("Delete Request for Materi ID: $id");

        try {
            $materi = Materi::findOrFail($id);
            $materi->delete();

            Log::info("Materi ID $id successfully deleted");

            return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus');
        } catch (\Exception $e) {
            Log::error("Failed to delete materi: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete materi.']);
        }
    }
}
