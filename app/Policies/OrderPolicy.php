<?php

namespace App\Policies;

use App\Models\OrderRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrderRecord $orderRecord): bool {
        return !in_array($orderRecord->status, [OrderRecord::STATUS_APPLY, OrderRecord::STATUS_CANCEL]) &&
                in_array($user->group_role,[User::ROLE_ADMINISTRATOR, User::ROLE_LOGIST, User::ROLE_CARRIER]);
    }

    public function statusSetWork(User $user, OrderRecord $orderRecord): bool {
        return  $orderRecord->status == OrderRecord::STATUS_NEW_ORDER &&
                in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_LOGIST]);
    }

    public function statusSetTravel(User $user, OrderRecord $orderRecord): bool {
        return  $orderRecord->status == OrderRecord::STATUS_WORK &&
                in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_LOGIST, User::ROLE_CARRIER]);
    }

    public function statusSetApply(User $user, OrderRecord $orderRecord): bool {
        return  $orderRecord->status == OrderRecord::STATUS_TRAVEL &&
                in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_CARRIER]);
    }

    public function statusSetCancel(User $user, OrderRecord $orderRecord): bool {
        return  in_array($orderRecord->status, [OrderRecord::STATUS_WORK, OrderRecord::STATUS_NEW_ORDER]) &&
                in_array($user->group_role, [User::ROLE_ADMINISTRATOR, User::ROLE_LOGIST]);
    }
}
