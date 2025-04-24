<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Listpage;
use App\Models\Prefecture;
use App\Models\Category;
use App\Models\Image;

class ListController extends Controller
{
    public function create()
    {
        // テーブルの全データを取得
        $prefectures = Prefecture::all();
        $categories = Category::all();
        $images = Image::all();

        return view('list.create', compact('prefectures', 'categories', 'images'));
    }

    public function store(Request $request)
    {
        //dd($request);
        // Validation
        $this->validate($request, Listpage::$rules);
        $page = new Listpage;
        $form = $request->all();
        //dd($request);
        //dd($request->hasFile('image'));
        //dd($request->file('image'));

        // user_idを認証ユーザーから取得
        $form['user_id'] = auth()->id();

        //フォームから送信されてきた[]を削除
        unset($form['_token']);
        unset($form['images']);
        //dd($form);

        // データベースに保存
        $page->fill($form);
        //dd($page);
        $page->save();

        // 画像保存処理
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $url = $file->store('public/images');
                $image = new Image([
                    'url' => str_replace('public/', 'storage/', $url),
                    'listpage_id' => $page->id,
                ]);
                $image->save();
            }
        }

        return redirect()->route('list.index');
    }

    public function submitForm(Request $request)
    {
        // 選択されたIDで検索
        $prefecture = Prefecture::find($request->input('prefecture'));
        $category = Category::find($request->input('category'));
        $image = Image::find($request->input('image'));

        return $prefecture->area . $category->name . $image->listpage_id;
    }

    public function index(Request $request, $prefectureId = null)
    {
        $type = $request->query('type', 'list');  // デフォルトはリスト
        //$prefectureId = $request->query('prefecture_id');  // 都道府県ID取得
        $query = Listpage::with(['prefecture', 'category', 'images']);

        if ($type === 'list') {
            $query->where('list_log', 0);  // リストだけ
        } else {
            $query->where('list_log', 1);  // アルバムだけ
        }

        // 都道府県で絞り込み
        if (!empty($prefectureId)) {
            $query->where('prefecture_id', $prefectureId);
        }

        $posts = $query->orderBy('created_at', 'desc')->get();

        // 選択中の都道府県名を取得
        $prefectureName = null;
        $weather = null;

        if (!empty($prefectureId)) {
            $prefecture = Prefecture::find($prefectureId);
            $prefectureName = $prefecture->area ?? '不明';
            // } else {
            // 都道府県が選択されていない場合はトップ画面にリダイレクト
            // return redirect()->route('top.top');

            // 都道府県が選択されていない場合
            // $prefectureName = '全エリア';
            // }

            //　天気API呼び出し（OpenWeatherMap）
            $apiKey = env('OPENWEATHER_API_KEY');
            $city = $prefecture->area;  // ここが都市名に対応している必要がある
            $apiurl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&lang=ja&units=metric";

            try {
                $response = Http::get($apiurl);
                $weather = $response->json();
            } catch (\Exception $e) {
                \Log::error("天気情報の取得失敗: " . $e->getMessage());
                $weather = '天気情報取得失敗';
            }
        } else {
            return redirect()->route('top.top');
        }

        // dd($weather);
        return view('list.index', [
            'posts' => $posts,
            'type' => $type,
            'prefectureId' => $prefectureId,
            'prefectureName' => $prefectureName,
            'weather' => $weather,
        ]);
    }

    public function edit($id)
    {
        // Listpage Modelからデータを取得（見つからない場合は404エラー）
        $listpage = Listpage::findOrFail($id);
        $prefectures = Prefecture::all();
        $categories = Category::all();
        $images = $listpage->images;
        //$images = Image::all();

        return view('list.edit', compact('listpage', 'prefectures', 'categories', 'images'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->id);
        // Validation
        $this->validate($request, Listpage::$rules);
        // Listpage Modelからデータを取得
        $page = Listpage::find($id);
        //dd($page);
        // フォームデータを取得
        $list_form = $request->all();

        // 画像削除処理（チェックされたものだけ削除）
        $removeImages = $request->input('remove', []);
        if (!empty($removeImages)) {
            $page->images()->whereIn('id', $removeImages)->delete();
        }

        // 画像アップロード処理
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $url = $file->store('public/images');
                $page->images()->create([
                    'url' => str_replace('public/', 'storage/', $url)
                ]);
            }
        }

        unset($list_form['images']);
        unset($list_form['remove']);
        unset($list_form['_token']);

        // 該当するデータを上書きして保存する
        $page->fill($list_form)->save();

        return redirect()->route('list.index', $request->input('prefecture_id'));
        //return redirect()->route('list.index', ['prefecture_id' => $request->input('prefecture_id')]);
    }

    public function delete(Request $request)
    {
        // Listpage Modelを取得
        $page = Listpage::find($request->id);
        // 削除する
        $page->delete();

        return redirect('list/index');
    }
}
