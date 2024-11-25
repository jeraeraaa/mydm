<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanKetum extends Model
{
    use HasFactory;

    protected $table = 'persetujuan_ketum';

    // Primary key, jika menggunakan nama selain 'id'
    protected $primaryKey = 'id_persetujuan_ketum';

    // Primary key bukan integer auto-increment
    public $incrementing = true;
    public $timestamps = false;

    // Tipe primary key
    protected $keyType = 'int';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_ketum',                // ID Ketua Umum
        'status_persetujuan',      // Status: menunggu, disetujui, ditolak
        'catatan',
        'updated_at',
        'created_at',                 
    ];

    /**
     * Relasi ke model KetuaUmum
     * Setiap persetujuan dikaitkan dengan satu Ketua Umum
     */
    public function ketuaUmum()
    {
        return $this->belongsTo(KetuaUmum::class, 'id_ketum', 'id_ketum');
    }

    /**
     * Relasi polimorfik ke peminjamable (anggota atau peminjam eksternal)
     * Jika diperlukan untuk mengelola peminjam
     */
    public function peminjamable()
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke model DetailPeminjamanAlat
     * Setiap persetujuan mencakup banyak detail peminjaman
     */
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjamanAlat::class, 'id_persetujuan_ketum', 'id_persetujuan_ketum');
    }

    /**
     * Accessor untuk status persetujuan dalam bentuk deskriptif
     * Mengembalikan status: "Menunggu Persetujuan", "Disetujui", atau "Ditolak"
     */
    public function getStatusPersetujuanTextAttribute()
    {
        switch ($this->status_persetujuan) {
            case 'disetujui':
                return 'Disetujui';
            case 'ditolak':
                return 'Ditolak';
            default:
                return 'Menunggu Persetujuan';
        }
    }
}
