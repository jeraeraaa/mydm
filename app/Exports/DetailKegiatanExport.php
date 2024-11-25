<?php

namespace App\Exports;

use App\Models\DetailKegiatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailKegiatanExport implements FromCollection, WithHeadings
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
        $query = DetailKegiatan::select(
            'id_detail_kegiatan',
            'nama_detail_kegiatan',
            'tanggal_mulai',
            'tanggal_selesai',
            'waktu_mulai',
            'waktu_selesai',
            'lokasi'
        );

        if ($this->request->filled('tanggal_mulai') && $this->request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_mulai', [
                $this->request->tanggal_mulai,
                $this->request->tanggal_selesai
            ]);
        } elseif ($this->request->filled('tanggal_mulai')) {
            $query->where('tanggal_mulai', '>=', $this->request->tanggal_mulai);
        } elseif ($this->request->filled('tanggal_selesai')) {
            $query->where('tanggal_mulai', '<=', $this->request->tanggal_selesai);
        }

        return $query->orderBy('tanggal_mulai', 'asc')->get();
    }

    // Menentukan heading untuk kolom Excel
    public function headings(): array
    {
        return [
            'ID Detail Kegiatan',
            'Nama Detail Kegiatan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Waktu Mulai',
            'Waktu Selesai',
            'Lokasi',
        ];
    }
}
