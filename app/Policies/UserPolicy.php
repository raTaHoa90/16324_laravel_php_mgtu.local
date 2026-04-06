<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy {
    public function menuUsers(User $user): bool {
        return in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_MANAGER]);
    }

    public function menuProducts(User $user){
        return in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_CONTENT_M]);
    }

    public function menuOrders(User $user){
        return in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_CARRIER, User::ROLE_LOGIST]);
    }
}
