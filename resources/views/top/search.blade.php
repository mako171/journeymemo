@extends('layouts.app')

@section('title', '検索ページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
<link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h2>検索ページ</h2>
    </div>
    <div class="col-md-12">
        <hr color="#c0c0c0">
        <!-- <a href="{{ route('top.top') }}" class="btn btn-outline-danger">トップページ</a> -->
        <form action="{{ route('top.search') }}" method="get">
            <div class="form-group row">
                <label class="col-md-3">
                    <strong>タイトル</strong>
                </label>
            </div>
            <div class="col-md-8 d-flex">
                <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                <input type="submit" class="title-search-button" value="検索">
            </div>

            <div class="mt-3">
                <div class="form-group row">
                    <label class="col-md-3">
                        <strong>カテゴリ</strong>
                    </label>
                </div>
            </div>
            <!-- カテゴリをボタン選択 -->
            <div class="col-md-12">
                <div class="menu-grid">
                    @foreach($categories as $category)
                    <button type="submit" class="menu-button category-button-style" name="cond_category" value="{{ $category->id }}">{{ $category->name }}
                    </button>
                    @endforeach
                </div>
            </div>
        </form>
        <div class="my-4 my-6:md">
            <hr color="#c0c0c0">
        </div>
    </div>
</div>

<!-- チェックボックス追加 -->
<form action="{{ route('top.select') }}" method="get">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="row">
                <div class="table-responsive">
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
                </div>
                <!-- まとめて確認ボタン -->
                <button type="submit" class="summarize-in-full">詳細を見る</button>
            </div>
        </div>
    </div>
</form>
@endsection