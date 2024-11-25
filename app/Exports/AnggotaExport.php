<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class AnggotaExport implements FromCollection
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = DB::table('anggota')
            ->join('program_studi', 'anggota.id_prodi', '=', 'program_studi.id_prodi')
            ->select(
                'anggota.id_anggota',
                'anggota.nama_anggota',
                'program_studi.nama_prodi',
                'anggota.email',
                'anggota.no_hp',
                'anggota.jenis_kelamin',
                'anggota.tanggal_lahir'
            );

        // Tambahkan filter
        if (!empty($this->filter['tanggal_lahir_start']) && !empty($this->filter['tanggal_lahir_end'])) {
            $query->whereBetween('anggota.tanggal_lahir', [$this->filter['tanggal_lahir_start'], $this->filter['tanggal_lahir_end']]);
        } elseif (!empty($this->filter['tanggal_lahir_start'])) {
            $query->whereDate('anggota.tanggal_lahir', '>=', $this->filter['tanggal_lahir_start']);
        } elseif (!empty($this->filter['tanggal_lahir_end'])) {
            $query->whereDate('anggota.tanggal_lahir', '<=', $this->filter['tanggal_lahir_end']);
        }

        if (!empty($this->filter['id_prodi'])) {
            $query->whereIn('anggota.id_prodi', $this->filter['id_prodi']);
        }

        return $query->orderBy('anggota.nama_anggota', 'asc')->get();
    }
}
