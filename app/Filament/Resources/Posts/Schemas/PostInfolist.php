<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Post;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Post details')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User'),

                        TextEntry::make('type')
                            ->label('Type')
                            ->formatStateUsing(fn(PostType $state) => $state->label())
                            ->color(fn(PostType $state) => $state->color())
                            ->badge(),

                        TextEntry::make('title')
                            ->label('Title'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn(PostStatus $state) => $state->label())
                            ->color(fn(PostStatus $state) => $state->color())
                            ->badge(),

                        TextEntry::make('published_at')
                            ->label('Published at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Content')
                    ->schema([
                        TextEntry::make('content')
                            ->label('')
                            ->html()
                            ->columnSpanFull()
                            ->placeholder('No content'),
                    ])
                    ->columnSpanFull(),

                Section::make('Images')
                    ->schema([
                        TextEntry::make('media_paths')
                            ->label('Images')
                            ->state(function (Post $record) {
                                return $record->media
                                    ->pluck('path')
                                    ->all();
                            })
                            ->listWithLineBreaks(),
                    ])
                    ->visible(
                        fn(Post $record): bool =>
                        $record->type === PostType::IMAGE
                    )
                    ->columnSpanFull(),

                Section::make('Video')
                    ->schema([
                        TextEntry::make('video.provider')
                            ->label('Provider'),

                        TextEntry::make('video.video_id')
                            ->label('Video ID'),

                        TextEntry::make('video.thumbnail')
                            ->label('Thumbnail')
                            ->placeholder('-'),
                    ])
                    ->visible(
                        fn(Post $record): bool =>
                        $record->type === PostType::VIDEO
                    )
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Poll')
                    ->schema([
                        TextEntry::make('poll.multiple_choice')
                            ->label('Selección múltiple')
                            ->formatStateUsing(
                                fn($state) => $state ? 'Sí' : 'No'
                            )
                            ->badge(),

                        TextEntry::make('poll.ends_at')
                            ->label('Ends at')
                            ->dateTime()
                            ->placeholder('No date'),

                        TextEntry::make('poll_options')
                            ->label('Options')
                            ->state(function (Post $record) {
                                return $record->poll?->options
                                    ->pluck('text')
                                    ->all() ?? [];
                            })
                            ->listWithLineBreaks(),
                    ])
                    ->visible(
                        fn(Post $record): bool =>
                        $record->type === PostType::POLL
                    )
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('System information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Updated at')
                            ->dateTime(),

                        TextEntry::make('deleted_at')
                            ->label('Deleted at')
                            ->dateTime()
                            ->placeholder('No eliminado')
                            ->visible(
                                fn(Post $record): bool =>
                                $record->trashed()
                            ),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
