<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role details')
                    ->schema([
                        TextEntry::make('name'),

                        TextEntry::make('display_name'),

                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        IconEntry::make('active')
                            ->boolean(),

                        IconEntry::make('system')
                            ->boolean(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Permissions')
                    ->collapsible()
                    ->collapsed()
                    ->schema(function ($record) {
                        return $record->permissions
                            ->groupBy('resource')
                            ->map(function ($permissions, $resource) {
                                return TextEntry::make("permissions_{$resource}")
                                    ->label(ucfirst($resource))
                                    ->state(
                                        $permissions
                                            ->pluck('display_name')
                                            ->toArray()
                                    )
                                    ->badge()
                                    ->columnSpanFull();
                            })
                            ->values()
                            ->all();
                    })
                    ->columnSpanFull(),

                Section::make('System information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
