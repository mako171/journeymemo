@extends('layouts.front')

@section('title', '検索ページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
<link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="col-md-9 mx-auto">
        <div class="row">
            <h2><strong>検索ページ</strong></h2>
            <div class="thick-line mb-4">
            </div>
        </div>
        <!-- <hr color="#c0c0c0"> -->
        <h5><strong>絞り込む</strong></h5>
        <div class="col-md-12 d-flex flex-column align-items-center">
            <!-- <a href=" {{ route('top.top') }}" class="btn btn-outline-danger">トップページ</a> -->
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
            <div class="mb-3">
            </div>
        </div>
        <hr color="#c0c0c0">
    </div>
</div>

<!-- チェックボックス追加 -->
<form action="{{ route('top.select') }}" method="get">
    <div class="row">
        <div class="col-md-9 mx-auto mt-3">
            <!-- <div class="row"> -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr class="selection-title">
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
                            <!-- <td>
                                    <div>
                                    <a href="{{ route('top.select', ['id' => $post->id]) }}">詳細</a>
                                </div>
                                </td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- ページネーションリンク -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $posts->appends(['cond_title' => $cond_title, 'cond_category' => $cond_category])->links() }}
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <!-- 画面表示されている項目の最初の連番 -->
                    {{ $posts->firstItem() }}
                    <span>〜</span>
                    <!-- 画面表示されている項目の最後の連番 -->
                    {{ $posts->lastItem() }}
                    <span>件 / </span>
                    <!-- 全件数 -->
                    {{ $posts->total() }}
                    <span>件</span>
                </div>

                <!-- まとめて確認ボタン -->
                <button type="submit" class="summarize-in-full">選択した項目を見る</button>
                <!-- </div> -->
            </div>
        </div>
    </div>
</form>
@endsection