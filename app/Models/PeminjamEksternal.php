<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamEksternal extends Model
{
    use HasFactory;

    protected $table = 'peminjam_eksternal';
    protected $fillable = [
        'nama',
        'jurusan',
        'organisasi',
    ];

    public function detailPeminjamanAlat()
    {
        return $this->morphMany(DetailPeminjamanAlat::class, 'peminjamable');
    }
}
