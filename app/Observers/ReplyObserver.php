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
        // 命令行运行迁移时不做这些操作！
        if (!app()->runningInConsole()) {
            $reply->topic->updateReplyCount();
            // 通知话题作者有新的评论
            $reply->topic->user->notifyAndStat(new ReplyWrote($reply));
        }
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
