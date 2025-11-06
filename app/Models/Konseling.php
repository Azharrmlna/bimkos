<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_masalah',
        'deskripsi',
        'status',
        'catatan_guru',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}