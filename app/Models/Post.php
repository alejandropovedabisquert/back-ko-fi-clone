<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
        'type',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatus::class,
        'type' => PostType::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function media()
    {
        return $this->hasMany(PostMedia::class)
            ->orderBy('sort_order');
    }

    public function video()
    {
        return $this->hasOne(PostVideo::class);
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }
}
