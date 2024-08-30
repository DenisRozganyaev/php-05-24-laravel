<?php

namespace App\Broadcasting;

use App\Enums\Role;
use App\Models\User;

class AdminChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        logs()->info(self::class.' => '.$user->hasRole(Role::ADMIN->value).' | Email: '.$user->email);

        return $user->hasRole(Role::ADMIN->value);
    }
}
