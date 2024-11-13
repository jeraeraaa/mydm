<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'id_materi';
    public $incrementing = true;
    protected $fillable = [
        'nama_materi',
        'deskripsi_materi',
        'id_detail_kegiatan',
        'id_pembicara'
    ];

    /**
     * Relasi ke model Pembicara.
     * Setiap materi memiliki satu pembicara.
     */
    public function pembicara()
    {
        return $this->belongsTo(Pembicara::class, 'id_pembicara', 'id_pembicara');
    }

    /**
     * Relasi ke model DetailKegiatan.
     * Setiap materi terkait dengan satu detail_kegiatan.
     */
    public function detailKegiatan()
    {
        return $this->belongsTo(DetailKegiatan::class, 'id_detail_kegiatan', 'id_detail_kegiatan');
    }
}
