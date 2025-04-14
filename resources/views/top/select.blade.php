@extends('layouts.front')

@section('title', '選択内容')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
<link rel="stylesheet" href="{{ asset('css/list_log.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="col-md-9 mx-auto">
        <h2><strong>選択した項目</strong></h2>
        <div class="mb-4">
            <!-- <a href="{{ route('list.create') }}" class="btn btn-outline-secondary">新規作成</a>
        <a href="{{ route('top.top') }}" class="btn btn-outline-danger">トップページ</a> -->
            <div class="thick-line mb-3">
            </div>
        </div>

        @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-header">
                <h3>{{ $post->title }}</h3>
            </div>
            <div class="card-body">
                <p><strong>リスト/アルバム : </strong> {{ $post->list_log == 0 ? 'リスト' : 'アルバム' }}</p>
                <p><strong>都道府県 : </strong> {{ $post->prefecture->area ?? '未設定' }}</p>
                <p><strong>カテゴリ : </strong> {{ $post->category->name ?? '未設定' }}</p>
                <p><strong>本文 : </strong><br>{!! nl2br(e($post->body)) !!}</p>
                @if($post->images->isNotEmpty())
                <div class="image-grid">
                    @foreach($post->images as $image)
                    <img src="{{ asset($image->url) }}" alt="Image" class="post-image">
                    @endforeach
                </div>
                @endif
                <div class="mt-2">
                    <div class="button-container">
                        <form action="{{ route('list.edit', ['id' => $post->id]) }}" method="GET" style="display: inline;">
                            @csrf
                            <button type="submit" class="list-edit-button">編集</button>
                        </form>

                        <form action="{{ route('list.delete') }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <button type="submit" class="list-edit-button">削除</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    body {
        background-color: #fff9c494;
        /* 背景色 */
    }
</style>
@endsection

@section('scripts')
<script>
    window.addEventListener('DOMContentLoaded', () => {
        localStorage.removeItem('selectedItems');
    });
</script>
@endsection