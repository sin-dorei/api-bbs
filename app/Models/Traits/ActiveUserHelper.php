<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;
use Carbon\Carbon;
use Cache;

trait ActiveUserHelper
{
    // 用于存放临时用户数据
    protected $users = [];

    // 配置信息
    protected $topic_weight = 5; // 话题权重
    protected $reply_weight = 1; // 回复权重
    protected $pass_days = 30;    // 多少天内发表过内容
    protected $user_number = 6; // 取出来多少用户

    // 缓存相关配置
    protected $cache_key = 'bbs_active_users';
    protected $cache_expire = 60 * 60;

    public function getActiveUsers()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire, function(){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 并加以缓存
        $this->cacheActiveUsers($active_users);
    }

    private function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        $users = array_reverse(array_slice(collect($this->users)->sortBy('score')->reverse()->toArray(), 0, $this->user_number, true), true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $score) {
            $user = User::find($user_id);
            // 将此用户实体放入集合的末尾
            $active_users->push($user);
        }

        // \Log::info(json_encode($users));
        // \Log::info(json_encode($active_users));

        return $active_users;
    }

    private function calculateTopicScore()
    {
        // 从话题数据表里取出限定时间范围（$pass_days）内，有发表过话题的用户
        // 并且同时取出用户此段时间内发布话题的数量
        $topic_users = Topic::selectRaw('user_id, COUNT(*) AS topic_count')->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))->groupBy('user_id')->get();

        foreach ($topic_users as $topic_user) {
            $topic_score = $topic_user->topic_count * $this->topic_weight;
            $this->users[$topic_user->user_id] = ['score' => $topic_score];
        }
    }

    private function calculateReplyScore()
    {
        // 从回复数据表里取出限定时间范围（$pass_days）内，有发表过回复的用户
        // 并且同时取出用户此段时间内发布回复的数量
        $reply_users = Reply::selectRaw('user_id, COUNT(*) AS reply_count')->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))->groupBy('user_id')->get();

        foreach ($reply_users as $reply_user) {
            $reply_score = $reply_user->reply_count * $this->reply_weight;
            if (!isset($this->users[$reply_user->user_id])) {
                $this->users[$reply_user->user_id] = ['score' => $reply_score];
            }
            $this->users[$reply_user->user_id]['score'] += $reply_score;
        }
    }

    private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire);
    }

    // public function calculateActiveUsers()
    // {
    //     $duration = date('Y-m-d H:i:s', time() - 7 * 24 * 3600);
    //     $users = User::all();
    //     foreach ($users as $user) {
    //         $score = 0;
    //         $topics = $user->topics()->where('created_at', '>=', $duration)->get();
    //         $score += count($topics) * 5;

    //         $replies = $user->replies()->where('created_at', '>=', $duration)->get();
    //         $score += count($replies) * 1;

    //         array_push($data, [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'score' => $score
    //         ]);
    //     }

    //     $data = array_slice(collect($data)->sortBy('score')->reverse()->toArray(), 0, 10);
    // }
}
