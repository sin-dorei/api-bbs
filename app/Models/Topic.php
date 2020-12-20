<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function feed($category_id)
    {
        if (!$category_id) {
            return $this->orderBy('updated_at', 'desc')->with('user', 'category');
        }
        return $this->where('category_id', $category_id)->orderBy('updated_at', 'desc')->with('user', 'category');
    }
}
