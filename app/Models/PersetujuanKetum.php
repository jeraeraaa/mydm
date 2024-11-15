<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanKetum extends Model
{
    use HasFactory;

    protected $table = 'persetujuan_ketum';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_ketum',
        'status_persetujuan',
        'catatan',
    ];

    /**
     * Relasi ke model KetuaUmum
     */
    public function ketuaUmum()
    {
        return $this->belongsTo(KetuaUmum::class, 'id_ketum', 'id_ketum');
    }

    /**
     * Relasi ke model DetailPeminjamanAlat
     */
    public function detailPeminjamanAlat()
    {
        return $this->hasMany(DetailPeminjamanAlat::class, 'id_persetujuan_ketum', 'id_persetujuan_ketum');
    }

    /**
     * Accessor untuk status persetujuan dalam bentuk deskriptif.
     * Mengembalikan status dalam bentuk teks deskriptif: "Menunggu Persetujuan", "Disetujui", atau "Ditolak".
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
