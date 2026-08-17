<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PostMedia extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'post_id',
        'path',
        'alt',
        'caption',
        'sort_order',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
