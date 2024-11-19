<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamEksternal extends Model
{
    use HasFactory;

    protected $table = 'peminjam_eksternal';
    protected $primaryKey = 'id_peminjam_eksternal';
    public $incrementing = false;
    protected $keyType = 'string';


    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_peminjam_eksternal',
        'nama',
        'id_prodi',      // Mengganti 'jurusan' dengan 'id_prodi' agar sesuai dengan migrasi
        'organisasi',
    ];

    // Relasi ke model DetailPeminjamanAlat (polymorphic)
    public function detailPeminjamanAlat()
    {
        return $this->morphMany(DetailPeminjamanAlat::class, 'peminjamable');
    }

    /**
     * Relasi ke model ProgramStudi.
     * Setiap peminjam eksternal berhubungan dengan satu program studi.
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }
}
