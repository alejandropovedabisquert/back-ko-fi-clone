<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Poll extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'post_id',
        'multiple_choice',
        'ends_at',
    ];

    protected $casts = [
        'multiple_choice' => 'boolean',
        'ends_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function options()
    {
        return $this->hasMany(PollOption::class)
            ->orderBy('sort_order');
    }
}
