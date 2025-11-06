<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'lokasi',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now())->orderBy('tanggal', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('tanggal', '<', now())->orderBy('tanggal', 'desc');
    }
}