<?php

namespace App\Enums;

enum PostType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case BLOG = 'blog';
    case VIDEO = 'video';
    case POLL = 'poll';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::BLOG => 'Blog',
            self::IMAGE => 'Images',
            self::VIDEO => 'Video',
            self::POLL => 'Poll',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TEXT => 'gray',
            self::BLOG => 'info',
            self::IMAGE => 'success',
            self::VIDEO => 'warning',
            self::POLL => 'danger',
        };
    }
    
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $options, self $type) => [
                ...$options,
                $type->value => $type->label(),
            ],
            [],
        );
    }
}
