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

    // Tipe data untuk casting
    protected $casts = [
        'status_persetujuan' => 'boolean',
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
     * Mengembalikan "Disetujui" jika status_persetujuan true, "Tidak Disetujui" jika false.
     */
    public function getStatusPersetujuanTextAttribute()
    {
        return $this->status_persetujuan ? 'Disetujui' : 'Tidak Disetujui';
    }
}
