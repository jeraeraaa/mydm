<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    protected $id_detail_kegiatan;

    public function __construct($id_detail_kegiatan)
    {
        $this->id_detail_kegiatan = $id_detail_kegiatan;
    }

    public function collection()
    {
        return Absensi::with(['anggota', 'pengunjung', 'detailKegiatan'])
            ->where('id_detail_kegiatan', $this->id_detail_kegiatan)
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->anggota->nama_anggota ?? $item->pengunjung->nama_pengunjung,
                    'Tipe' => $item->anggota ? 'Anggota' : 'Pengunjung',
                    'No HP' => $item->pengunjung->no_hp ?? '-',
                    'Waktu Masuk' => \Carbon\Carbon::parse($item->waktu_masuk)->format('d/m/Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Tipe', 'No HP', 'Waktu Masuk'];
    }
}
