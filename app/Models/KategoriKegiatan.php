<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'kategori_kegiatan';

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_kategori_kegiatan');
    }
}
