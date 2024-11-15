<?php

namespace App\Policies;

use App\Models\Revenue;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RevenuePolicy
{
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function modify(User $user, Revenue $revenue): Response
    {
        return $user->id === $revenue->user_id
            ? Response::allow()
            : Response::deny('You are not authorized to modify this revenue');
    }
}
