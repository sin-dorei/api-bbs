<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title', 'body', 'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFeed($query, $order, $category_id = null)
    {
        if (!$category_id) {
            return $query->withOrder($order)->with('user', 'category');
        }
        return $query->where('category_id', $category_id)->withOrder($order)->with('user', 'category');
    }

    public function scopeWithOrder($query, $order)
    {
        if ($order === 'recent') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('updated_at', 'desc');
        }
    }

    public function link($params  = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
