<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjamanAlat extends Model
{
    use HasFactory;
    protected $table = 'detail_peminjaman_alat';
    protected $fillable = [
        'peminjamable_id',
        'peminjamable_type',
        'id_alat',
        'id_inventaris',
        'id_persetujuan_ketum',
        'tanggal_pinjam',
        'tanggal_kembali',
        'kondisi_alat_dipinjam',
        'kondisi_setelah_dikembalikan',
        'catatan',
        'jumlah_dipinjam',
    ];

    // Relasi ke model 'Alat'
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }

    // Relasi ke model 'Inventaris'
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'id_inventaris', 'id_inventaris');
    }

    // Relasi ke model 'PersetujuanKetum'
    public function persetujuanKetum()
    {
        return $this->belongsTo(PersetujuanKetum::class, 'id_persetujuan_ketum', 'id_persetujuan_ketum');
    }

    // Relasi polimorfik ke peminjam (Anggota atau PeminjamEksternal)
    public function peminjamable()
    {
        return $this->morphTo();
    }
}