<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use App\Models\Role;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('roles')
                    ->label('Administrative roles')
                    ->relationship('roles', 'display_name')
                    ->multiple()
                    ->preload()
                    ->visible(fn () => Filament::auth()->user()?->hasRole('admin'))
                    ->searchable(),
                Select::make('account_type')
                    ->label('Account type')
                    ->options([
                        'user' => 'Usuario',
                        'creator' => 'Creador',
                    ])
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->helperText(fn(string $operation): ?string =>
                    $operation === 'edit'
                        ? 'Leave this field blank to keep your current password.'
                        : null)
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn($state) => filled($state)),
            ]);
    }
}
