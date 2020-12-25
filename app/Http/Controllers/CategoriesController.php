<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use App\Models\Link;

class CategoriesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request, User $user, Link $link)
    {
        if ($category) {
            $category = Category::where('id', $category->id)->first();
            // dd($category->name);
        }

        $topics = Topic::feed($request->order, $category->id)->paginate(20);

        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        // 资源链接
        $links = $link->getAllCached();

        return view('topics.index', compact('category', 'topics', 'active_users', 'links'));
    }
}
