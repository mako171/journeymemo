@extends('layouts.app')

@section('title', '検索ページ')

@section('content')
<div class="container">
    <div class="row">
        <h2>検索ページ</h2>
    </div>
    <div class="col-md-8">
        <!-- <a href="{{ route('top.top') }}" class="btn btn-outline-danger">トップページ</a> -->
        <form action="{{ route('top.index') }}" method="get">
            <div class="form-group row">
                <label class="col-md-3">タイトル</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
            </div>
            <div class="mt-1">
                <input type="submit" class="btn btn-secondary" value="検索">
            </div>
            <div class="mt-3">
                <div class="form-group row">
                    <label class="col-md-3">カテゴリ</label>
                </div>
            </div>

            <!-- カテゴリをボタン選択 -->
            <div class="col-md-10">
                <div class="menu-grid">
                    @foreach($categories as $category)
                    <button type="submit" class="menu-button" name="cond_category" value="{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>

<!-- チェックボックス追加 -->
<form action="{{ route('top.select') }}" method="get">
    <div class="row">
        <div class="mt-3">
            <div class="col-md-8 mx-auto">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="20%">リスト/アルバム</th>
                                <th width="20%">都道府県</th>
                                <th width="20%">カテゴリ</th>
                                <th width="35%">タイトル</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_posts[]" value="{{ $post->id }}">
                                </td>
                                <td>{{ Str::limit($post->list_log == 0 ? 'リスト' : 'アルバム', 100) }}</td>
                                <td>{{ Str::limit($post->prefecture->area ?? '未設定', 100) }}</td>
                                <td>{{ Str::limit($post->category->name ?? '未設定', 100) }}</td>
                                <td>{{ Str::limit($post->title, 100) }}</td>
                                <td>
                                    <!-- <div>
                                    <a href="{{ route('top.select', ['id' => $post->id]) }}">詳細</a>
                                </div> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- まとめて確認ボタン -->
                    <button type="submit" class="btn btn-primary">詳細を見る</button>

                </div>
            </div>
        </div>
    </div>
</form>
@endsection