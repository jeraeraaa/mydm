<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'kategori_kegiatan';
    protected $primaryKey = 'id_kategori_kegiatan';
    public $incrementing = true;
    protected $fillable = [
        'nama_kategori',
    ];
    public function kegiatan()
    {
        return $this->hasOne(Kegiatan::class, 'id_kategori_kegiatan', 'id_kategori_kegiatan');
    }
}
