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

    public function ketuaUmum()
    {
        return $this->belongsTo(KetuaUmum::class, 'id_ketum', 'id_ketum');
    }


    public function detailPeminjamanAlat()
    {
        return $this->hasMany(DetailPeminjamanAlat::class, 'id_persetujuan_ketum', 'id_persetujuan_ketum');
    }
}
