<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $table = 'pengunjung'; // Nama tabel
    protected $primaryKey = 'id_pengunjung'; // Primary key
    public $timestamps = false;
    
    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'nama_pengunjung',
        'no_hp',
    ];

    /**
     * Relasi ke tabel Absensi.
     * Satu pengunjung bisa hadir di banyak kegiatan.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_pengunjung', 'id_pengunjung');
    }
}
