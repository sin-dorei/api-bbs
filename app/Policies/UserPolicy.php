<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
{
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
