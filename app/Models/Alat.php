<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_alat',
        'id_bph',
        'nama_alat',
        'deskripsi',
        'jumlah_tersedia',
        'foto',
        'status_alat', // Menambahkan kolom status_alat ke fillable
    ];

    // Primary key pada tabel ini
    protected $primaryKey = 'id_alat';

    // Key ini bukan auto-incrementing karena kita pakai custom format
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    /**
     * Boot method for model events.
     * Automatically generate id_alat based on id_bph + increment.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Get the last ID for the current id_bph
            $lastId = self::where('id_bph', $model->id_bph)->max('id_alat');

            // Extract the increment part of the last id and increase it
            $increment = $lastId ? intval(substr($lastId, -3)) + 1 : 1;

            // Generate the new id_alat
            $model->id_alat = $model->id_bph . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Relationship to Bph model.
     * Setiap alat dimiliki oleh satu divisi BPH.
     */
    public function bph()
    {
        return $this->belongsTo(Bph::class, 'id_bph', 'id_bph');
    }

    /**
     * Relationship to DetailPeminjamanAlat model.
     * Satu alat dapat memiliki banyak detail peminjaman.
     */
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjamanAlat::class, 'id_alat', 'id_alat');
    }

    /**
     * Get the URL of the alat's photo.
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto ? Storage::url('public/alats/' . $this->foto) : asset('images/default_alat.png');
    }

    /**
     * Scope to filter alat by BPH division.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $bphId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByBph($query, $bphId)
    {
        return $query->where('id_bph', $bphId);
    }

    /**
     * Get the status description of the alat.
     * 
     * @return string
     */
    public function getStatusDescriptionAttribute()
    {
        $status = [
            'A' => 'Ada',
            'P' => 'Pinjam',
            'R' => 'Rusak',
        ];

        return $status[$this->status_alat] ?? 'Tidak Diketahui';
    }
}
