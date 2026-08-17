<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\AccountType;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User details')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('slug')
                            ->label('Slug')
                            ->placeholder('-'),
                        TextEntry::make('roles.display_name')
                            ->label('Roles')
                            ->getStateUsing(
                                fn($record) => $record->roles
                            )
                            ->placeholder('-')
                            ->badge(),
                        TextEntry::make('account_type')
                            ->label('Account type')
                            ->formatStateUsing(fn(AccountType $state) => $state->label())
                            ->color(fn(AccountType $state) => $state->color())
                            ->badge(),
                        TextEntry::make('email_verified_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('System information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Updated at')
                            ->dateTime()
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
