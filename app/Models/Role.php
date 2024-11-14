<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    // Kolom yang dapat diisi
    protected $fillable = [
        'name',
    ];

    /**
     * Relasi one-to-many dengan model Anggota.
     * Satu role dapat dimiliki oleh banyak anggota.
     */
    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'id_role', 'id');
    }
}
