<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    // Tentukan primary key custom
    protected $primaryKey = 'id_kegiatan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['id_kategori_kegiatan', 'nama_kegiatan', 'deskripsi_kegiatan'];


    public function detail_kegiatan()
    {
        return $this->hasOne(DetailKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function kategoriKegiatan()
    {
        return $this->belongsTo(KategoriKegiatan::class, 'id_kategori_kegiatan', 'id_kategori_kegiatan');
    }
}
