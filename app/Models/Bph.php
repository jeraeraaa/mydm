<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bph extends Model
{
    use HasFactory;
    protected $table = 'bph';
    protected $primaryKey = 'id_bph';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_bph',
        'nama_divisi_bph',
    ];

    public function kegiatan()
    {
        return $this->hasMany(DetailKegiatan::class, 'id_bph', 'id_bph');
    }
}
