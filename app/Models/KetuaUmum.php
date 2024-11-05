<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetuaUmum extends Model
{
    use HasFactory;

    protected $table = 'ketua_umum';

    protected $primaryKey = 'id_ketum';

    protected $fillable = [
        'id_anggota',
        'tahun_jabatan',
    ];

    /**
     * Relasi ke model Anggota.
     * Setiap Ketua Umum adalah satu Anggota.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Relasi ke model PersetujuanKetum.
     * Ketua Umum dapat memiliki banyak persetujuan.
     */
    public function persetujuanKetum()
    {
        return $this->hasMany(PersetujuanKetum::class, 'id_ketum', 'id_ketum');
    }
}
