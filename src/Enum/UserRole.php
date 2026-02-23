<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
    case MANAGER = 'ROLE_MANAGER';
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public function getLabel(): string
    {
        return match ($this) {
            self::USER => 'Utilisateur',
            self::ADMIN => 'Administrateur',
            self::MANAGER => 'Gestionnaire',
            self::SUPER_ADMIN => 'Super administrateur',
        };
    }
}
