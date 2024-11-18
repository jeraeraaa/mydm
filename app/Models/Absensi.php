<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi'; // Nama tabel
    protected $primaryKey = 'id_absensi'; // Primary key

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'id_anggota',
        'id_pengunjung',
        'id_detail_kegiatan',
        'waktu_masuk',
    ];

    /**
     * Relasi ke tabel Anggota.
     * Jika absensi dilakukan oleh anggota.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Relasi ke tabel Pengunjung.
     * Jika absensi dilakukan oleh pengunjung.
     */
    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class, 'id_pengunjung', 'id_pengunjung');
    }

    /**
     * Relasi ke tabel DetailKegiatan.
     * Setiap absensi terhubung ke detail kegiatan.
     */
    public function detailKegiatan()
    {
        return $this->belongsTo(DetailKegiatan::class, 'id_detail_kegiatan', 'id_detail_kegiatan');
    }
}
