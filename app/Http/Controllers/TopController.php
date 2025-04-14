<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Listpage;
use App\Models\Category;

class TopController extends Controller
{

    public function top()
    {
        $prefectures = Prefecture::all();

        return view('top.top', compact('prefectures'));
    }

    public function search(Request $request)
    {
        $cond_title = $request->cond_title;
        $cond_category = $request->cond_category;
        $query = Listpage::query();

        if ($cond_title != null) {
            $query->where('title', 'like', '%' . $cond_title . '%');
        }

        if ($cond_category) {
            $query->where('category_id', $cond_category);
        }

        // $posts = $query->orderBy('created_at', 'desc')->get();
        $posts = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();

        return view('top.search', [
            'posts' => $posts,
            'cond_title' => $cond_title,
            'cond_category' => $cond_category,
            'categories' => $categories
        ]);
    }

    public function select(Request $request)
    {
        //dd($request->all());
        // 選択されたIDを取得
        $selectedPostIds = $request->input('selected_posts');

        // IDが空の場合の処理
        if (!$selectedPostIds) {
            return redirect()->route('top.search')->with('error');
        }

        // 選択されたIDに対応するデータを取得
        $posts = Listpage::with(['prefecture', 'category', 'images'])
            ->whereIn('id', $selectedPostIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('top.select', compact('posts'));
    }
}
