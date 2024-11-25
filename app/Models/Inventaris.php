<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $primaryKey = 'id_inventaris';

    // Key ini bukan auto-incrementing karena kita pakai id anggota atau nim
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_anggota',
        'tahun_jabatan',
    ];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }


    public function detailPeminjamanAlat()
    {
        return $this->hasMany(DetailPeminjamanAlat::class, 'id_inventaris', 'id_inventaris');
    }
}
