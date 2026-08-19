<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Models\Permission;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        $record = $schema->getRecord();

        $permissions = Permission::query()
            ->orderBy('resource')
            ->orderBy('name')
            ->get()
            ->groupBy('resource');

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
                            ->default(true)
                            ->required(),

                        Toggle::make('system')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Permissions')
                    ->collapsible()
                    ->collapsed()
                    ->description(
                        'Select the permissions that users with this role will have.'
                    )
                    ->schema(
                        $permissions
                            ->map(
                                function ($resourcePermissions, $resource) use ($record) {
                                    $selectedPermissions = $record
                                        ? $record->permissions
                                        ->where('resource', $resource)
                                        ->pluck('id')
                                        ->map(fn($id) => (string) $id)
                                        ->toArray()
                                        : [];

                                    return Fieldset::make(ucfirst($resource))
                                        ->schema([
                                            CheckboxList::make(
                                                "permission_groups.{$resource}"
                                            )
                                                ->label('')
                                                ->options(
                                                    $resourcePermissions
                                                        ->pluck('display_name', 'id')
                                                        ->toArray()
                                                )
                                                ->default($selectedPermissions)
                                                ->columns(4)
                                                ->bulkToggleable()
                                                ->columnSpanFull()
                                                ->dehydrated(),
                                        ])
                                        ->columnSpanFull();
                                }
                            )
                            ->values()
                            ->all()
                    )
                    ->columnSpanFull(),
            ]);
    }
}
