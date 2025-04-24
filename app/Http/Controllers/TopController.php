<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        // dd($request->all());
        // 選択されたIDを取得
        // $selectedPostIds = $request->input('selected_posts');

        // IDが空の場合の処理
        // if (!$selectedPostIds) {
        //    return redirect()->route('top.search')->with('error');
        // }

        $selectedPostIds = session('selected_posts', []);

        if (empty($selectedPostIds)) {
            return redirect()->route('top.search')->with('error', '選択された項目がありません');
        }

        // 選択されたIDに対応するデータを取得
        $posts = Listpage::with(['prefecture', 'category', 'images'])
            ->whereIn('id', $selectedPostIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // セッションの選択データをリセット！
        session()->forget('selected_posts');

        return view('top.select', compact('posts'));
    }

    public function storeChecklist(Request $request)
    {
        $id = $request->input('id');
        $checked = $request->input('checked');

        // 現在のセッション内の選択済みIDを取得
        $selected = session()->get('selected_posts', []);

        if ($checked) {
            // チェックが入った → ID追加
            if (!in_array($id, $selected)) {
                $selected[] = $id;
            }
        } else {
            // チェックが外れた → ID削除
            $selected = array_filter($selected, function ($item) use ($id) {
                return $item != $id;
            });
        }
        // 更新後のデータをセッションに保存
        session()->put('selected_posts', $selected);

        return response()->json([
            'status' => 'success',
            'selected' => $selected
        ]);

        // dd("test");
        // return view('top.select');
    }
}
