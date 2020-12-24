<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
        // 命令行运行迁移时不做这些操作！
        if (!app()->runningInConsole()) {
            // 如 slug 字段无内容或 title 字段有改动，即使用翻译器对 title 进行翻译
            if (!$topic->slug || $topic->isDirty('title')) {
                // 推送任务到队列
                dispatch(new TranslateSlug($topic));
            }
        }
    }
}
