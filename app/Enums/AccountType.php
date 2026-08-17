<?php

namespace App\Enums;

enum AccountType: string
{
    case USER = 'user';
    case CREATOR = 'creator';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::CREATOR => 'Creator',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::USER => 'info',
            self::CREATOR => 'warning',
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
