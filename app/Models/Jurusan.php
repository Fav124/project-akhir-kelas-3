<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';

    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    /**
     * Get all kelas in this jurusan
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    /**
     * Get all santri in this jurusan
     */
    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}
