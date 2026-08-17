<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        $record = $schema->getRecord();

        return $schema
            ->components([
                ComponentsSection::make('Post details')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Type')
                            ->options(PostType::options())
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                        Select::make('status')
                            ->label('Status')
                            ->options(PostStatus::options())
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Published at'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                ComponentsSection::make('Content')
                    ->schema([
                        $record?->type === PostType::TEXT
                            ? Textarea::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull()
                            : RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                ComponentsSection::make('Images')
                    ->schema([
                        Repeater::make('media')
                            ->label('Images')
                            ->relationship('media')
                            ->schema([
                                TextInput::make('path')
                                    ->required(),

                                TextInput::make('alt'),

                                TextInput::make('caption'),

                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('type') === 'image')
                    ->columnSpanFull(),
                ComponentsSection::make('Video')
                    ->relationship('video')
                    ->schema([
                        Select::make('provider')
                            ->label('Provider')
                            ->options([
                                'youtube' => 'YouTube',
                                'vimeo' => 'Vimeo',
                            ])
                            ->required(),

                        TextInput::make('video_id')
                            ->label('Video ID')
                            ->required(),

                        TextInput::make('thumbnail')
                            ->label('Thumbnail'),
                    ])
                    ->visible(fn($get) => $get('type') === 'video')
                    ->columns(2)
                    ->columnSpanFull(),
                ComponentsSection::make('Poll')
                    ->relationship('poll')
                    ->schema([
                        Toggle::make('multiple_choice')
                            ->label('Selección múltiple'),

                        DateTimePicker::make('ends_at')
                            ->label('Ends at'),

                        Repeater::make('options')
                            ->relationship()
                            ->schema([
                                TextInput::make('text')
                                    ->label('Option')
                                    ->required(),

                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('type') === 'poll')
                    ->columnSpanFull(),
            ]);
    }
}
