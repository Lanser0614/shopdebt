<?php

namespace App\Constants;

enum RolesEnum: string
{
    case OWNER = 'owner';
    case SELLER = 'seller';

    public static function casesValue(): array
    {
        return array_column(RolesEnum::cases(), 'value');
    }
}
