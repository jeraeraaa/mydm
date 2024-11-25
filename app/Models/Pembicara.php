<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembicara extends Model
{
    use HasFactory;

    protected $table = 'pembicara';
    protected $primaryKey = 'id_pembicara';
    public $incrementing = true;
    protected $fillable = [
        'id_detail_kegiatan',
        'nama_pembicara',
        'kontak_pembicara',
    ];
    public $timestamps = false;
    
    /**
     * Relasi ke tabel DetailKegiatan.
     * Setiap pembicara berhubungan dengan satu DetailKegiatan.
     */
    public function detailKegiatan()
    {
        return $this->belongsTo(DetailKegiatan::class, 'id_detail_kegiatan', 'id_detail_kegiatan');
    }

    /**
     * Relasi satu-ke-satu dengan tabel Materi.
     * Setiap pembicara memiliki satu materi.
     */
    public function materi()
    {
        return $this->hasOne(Materi::class, 'id_pembicara', 'id_pembicara');
    }
}
