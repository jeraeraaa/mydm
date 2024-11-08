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

    protected $fillable = ['nama_kegiatan', 'kategori_kegiatan', 'deskripsi_kegiatan'];


    public function detail_kegiatan()
    {
        return $this->hasOne(DetailKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }
}
