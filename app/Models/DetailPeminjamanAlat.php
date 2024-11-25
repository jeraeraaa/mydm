<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DetailPeminjamanAlat extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman_alat';
    protected $primaryKey = 'id_detail_peminjaman_alat';
    public $timestamps = false;
    
    protected $fillable = [
        'peminjamable_id',
        'peminjamable_type',
        'id_alat',
        'id_inventaris',
        'id_persetujuan_ketum',
        'id_grup_peminjaman',
        'tanggal_pinjam',
        'tanggal_kembali',
        'kondisi_alat_dipinjam',
        'kondisi_setelah_dikembalikan',
        'catatan',
        'jumlah_dipinjam',
        'is_returned',
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

    public function grupPeminjaman()
    {
        return $this->belongsTo(PersetujuanKetum::class, 'id_grup_peminjaman', 'id_persetujuan_ketum');
    }

    // Accessor untuk status peminjaman
    public function getStatusPeminjamanAttribute()
    {
        Log::info('Accessor status_peminjaman', [
            'is_returned' => $this->is_returned,
            'status_persetujuan' => $this->persetujuanKetum->status_persetujuan ?? 'null',
        ]);

        if ($this->persetujuanKetum && $this->persetujuanKetum->status_persetujuan === 'ditolak') {
            return 'ditolak';
        }

        if ($this->is_returned) {
            return 'dikembalikan';
        }

        if ($this->persetujuanKetum && $this->persetujuanKetum->status_persetujuan === 'disetujui') {
            return 'dipinjam';
        }

        return 'menunggu persetujuan';
    }
}
