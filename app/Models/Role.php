<?php

namespace App\Models;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model implements HasLabel, HasColor
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'active',
        'system',
    ];

    public function getLabel(): string
    {
        return $this->display_name;
    }

    public function getColor(): string
    {
        return match ($this->name) {
            'admin' => 'danger',
            'moderator' => 'warning',
            'support' => 'info',
            default => 'gray',
        };
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
