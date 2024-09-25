<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    use HasFactory;

    protected $with = ['user', 'comments'];

    protected $withCount = ['likes'];

    protected $fillable = [
        'user_id',
        'content',
        'image'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'art_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'art_like')->withTimestamps();
    }

    public function scopeSearch($query, $search = ''): void
    {
        $query->where('content', 'like', '%' . $search . '%');
    }
}
