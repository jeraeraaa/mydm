<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'kategori_kegiatan';

    public function detail_kegiatan()
    {
        return $this->hasOne(DetailKegiatan::class, 'id_kategori_kegiatan', 'id_kategori_kegiatan');
    }
}
