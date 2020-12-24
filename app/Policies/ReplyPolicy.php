<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy extends Policy
{
    public function destroy(User $user, Reply $reply)
    {
        // \Log::info($user->isAuthorOf($reply));
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
