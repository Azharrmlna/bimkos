<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kelas',
        'foto',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function konselings()
    {
        return $this->hasMany(Konseling::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'created_by');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'created_by');
    }

    // Helper methods
    public function isGuruBK()
    {
        return $this->role === 'guru_bk';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
}