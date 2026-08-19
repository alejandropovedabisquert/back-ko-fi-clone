<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn(PostType $state) => $state->label())
                    ->color(fn(PostType $state) => $state->color()),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(PostStatus $state) => $state->label())
                    ->color(fn(PostStatus $state) => $state->color()),

                TextColumn::make('media_count')
                    ->counts('media')
                    ->label('Images'),

                IconColumn::make('video')
                    ->label('Video')
                    ->boolean(fn($record) => $record->video !== null),

                IconColumn::make('poll')
                    ->label('Poll')
                    ->boolean(fn($record) => $record->poll !== null),

                TextColumn::make('poll.options_count')
                    ->label('Poll Options')
                    ->getStateUsing(function ($record) {
                        return $record->poll?->options()->count() ?? 0;
                    }),

                TextColumn::make('published_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->since()
                    ->toggleable(),

                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(PostType::options()),
                SelectFilter::make('status')
                    ->options(PostStatus::options())
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
