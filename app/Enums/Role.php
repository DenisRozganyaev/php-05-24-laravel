<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case CUSTOMER = 'customer';

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $prop) {
            $values[] = $prop->value;
        }

        return $values;
    }
}
