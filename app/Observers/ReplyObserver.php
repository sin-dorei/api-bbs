<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\ReplyWrote;

class ReplyObserver
{
    public function saving(Reply $reply)
    {
        $reply->content = clean($reply->content);

        if ($reply->content === '') {
            return false;
        }
    }

    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount();

        $reply->topic->user->notifyAndStat(new ReplyWrote($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
