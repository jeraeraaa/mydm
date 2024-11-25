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
    public $timestamps = false;

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_peminjam_eksternal',
        'nama',
        'id_prodi',
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
    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }
}
