<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Models\Thread;
use App\Models\Event;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Los atributos recibiran datos masivos.
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'avatar',
        'bio',
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
            'is_admin' => 'boolean',
        ];
    }

    public function eventsAttending()
    {
        return $this->belongsToMany(Event::class, 'event_user')->withTimestamps();
    }

    // Accesor para obtener la URL del avatar
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        };
    }

    // Relación: usuarios que siguen a este usuario
    public function followers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'followers', 'followed_user_id', 'user_id');
    }

    // Relación: usuarios a los que este usuario sigue
    public function following()
    {
        return $this->belongsToMany(\App\Models\User::class, 'followers', 'user_id', 'followed_user_id');
    }

    // Relación: hilos creados por el usuario
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
