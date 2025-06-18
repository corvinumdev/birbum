<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Thread extends Model
{
    use HasFactory;

    // Campos que pueden asignarse masivamente
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'votes',
        'category_id',
        'image',
    ];
    // Relación con la categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con el autor (usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relación con los votos
    public function votes()
    {
        return $this->hasMany(\App\Models\ThreadVote::class);
    }

    // Saber si un usuario ya votó
    public function votedBy($user)
    {
        if (!$user) return false;
        return $this->votes()->where('user_id', $user->id)->exists();
    }
}
