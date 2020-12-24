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
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        $reply->topic->user->notifyAndStat(new ReplyWrote($reply));
    }
}
