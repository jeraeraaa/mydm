<?php

namespace App\Exports;

use App\Models\Alat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlatExport implements FromCollection, WithHeadings
{
    protected $request;

    // Constructor untuk menerima filter dari request
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // Mengambil data yang akan diekspor
    public function collection()
    {
        $query = Alat::join('bph', 'alat.id_bph', '=', 'bph.id_bph')
            ->select(
                'alat.id_alat',
                'alat.nama_alat',
                'alat.deskripsi',
                'alat.jumlah_tersedia',
                'alat.status_alat',
                'bph.nama_divisi_bph'
            );

        // Apply filter berdasarkan divisi BPH jika ada
        if ($this->request->filled('id_bph')) {
            $query->where('alat.id_bph', $this->request->id_bph);
        }

        return $query->get();
    }

    // Menentukan heading untuk kolom Excel
    public function headings(): array
    {
        return [
            'ID Alat',
            'Nama Alat',
            'Deskripsi',
            'Jumlah Tersedia',
            'Status',
            'Divisi BPH',
        ];
    }
}
