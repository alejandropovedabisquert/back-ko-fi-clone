<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PostVideo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'post_id',
        'provider',
        'video_id',
        'thumbnail',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
