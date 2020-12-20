<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Topic;

class CategoriesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request)
    {
        if ($category) {
            $category = Category::where('id', $category->id)->first();
            // dd($category->name);
        }

        $topics = Topic::feed($request->order, $category->id)->paginate(20);

        return view('topics.index', compact('category', 'topics'));
    }
}
