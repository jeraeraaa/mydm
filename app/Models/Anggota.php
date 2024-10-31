<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false; // Karena id_anggota bukan auto-increment
    protected $keyType = 'string'; 

    protected $hidden = [
        'password',
    ];
    

    protected $fillable = [
        'id_anggota', 
        'id_prodi',
        'nama_anggota',
        'email',
        'password',
        'no_hp',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'foto_profil',
    ];

    // Relationship to Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}
