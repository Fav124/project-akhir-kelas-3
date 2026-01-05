<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'jurusan_id'
    ];

    /**
     * Get the jurusan that owns this kelas
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Get all santri in this kelas
     */
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }

    /**
     * Get full name with jurusan
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->nama_kelas;
        if ($this->jurusan) {
            $name .= ' - ' . $this->jurusan->nama;
        }
        return $name;
    }
}
