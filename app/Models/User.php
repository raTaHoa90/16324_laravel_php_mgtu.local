<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Policies\UserPolicy;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[UsePolicy(UserPolicy::class)]
#[Fillable(['name', 'email', 'password', 'group_role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const
        ROLE_GUEST = 0,
        ROLE_ADMINISTRATOR = 1,
        ROLE_MANAGER = 2,   // менеджер по персоналу
        ROLE_LOGIST = 3,    // Логист, управляет заказами
        ROLE_CONTENT_M = 4, // Контент-менеджер, управляет информацией о товаре
        ROLE_CARRIER = 5,   // Курьер
        ROLE_CLIENT = 10,
        ROLE_BANNED = -1,

        ROLES = [
            self::ROLE_GUEST => 'гость',
            self::ROLE_ADMINISTRATOR => 'Администратор',
            self::ROLE_MANAGER => 'Менеджер по персоналу',
            self::ROLE_LOGIST => 'Логист',
            self::ROLE_CONTENT_M => 'Контент-менеджер',
            self::ROLE_CARRIER => 'Курьер',
            self::ROLE_CLIENT => 'Покупатель',
            self::ROLE_BANNED => 'Заблокирован'
        ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function roleName(): string {
        return static::ROLES[$this->group_role] ?? '???';
    }

    function NotUseAdminPanel(): bool {
        return in_array($this->group_role, [static::ROLE_GUEST, static::ROLE_CLIENT]);
    }

    function isAdmin(): bool {
        return $this->group_role == static::ROLE_ADMINISTRATOR;
    }

    function isManager(): bool {
        return $this->group_role == static::ROLE_MANAGER;
    }
}
