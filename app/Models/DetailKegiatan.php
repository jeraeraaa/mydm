<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKegiatan extends Model
{
    use HasFactory;
    protected $table = 'detail_kegiatan';
    protected $primaryKey = 'id_detail_kegiatan';
    public $incrementing = true;
    protected $fillable = [
        'id_bph',
        'id_kegiatan',
        'nama_detail_kegiatan',
        'deskripsi_detail',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'foto',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function bph()
    {
        return $this->belongsTo(Bph::class, 'id_bph', 'id_bph');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_detail_kegiatan');
    }

}
