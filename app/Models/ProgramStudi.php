<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi'; // Mengubah nama tabel agar sesuai dengan migrasi
    protected $primaryKey = 'id_prodi';
    public $incrementing = false; // Menambahkan untuk memastikan id_prodi tidak auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_fakultas',
        'nama_prodi',
    ];

    /**
     * Relasi ke model Fakultas.
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }
}