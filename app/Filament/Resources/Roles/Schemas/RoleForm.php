<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role details')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('display_name')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Toggle::make('active')
                            ->required(),
                        Toggle::make('system')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
