@extends('layouts.app')

@section('title', '候補リスト')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2>候補リスト</h2>
            <a href="{{ route('list.create') }}">リスト追加</a>

            @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-header">
                    <h3>{{ $post->title }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>リスト/アルバム : </strong> {{ $post->list_log == 0 ? 'リスト' : 'アルバム' }}</p>
                    <p><strong>都道府県 : </strong> {{ $post->prefecture->area ?? '未設定' }}</p>
                    <p><strong>カテゴリ : </strong> {{ $post->category->name ?? '未設定' }}</p>
                    <p><strong>本文 : </strong> {{ $post->body }}</p>
                    @if($post->images->isNotEmpty())
                    <div class="mb-3">
                        @foreach($post->images as $image)
                        <img src="{{ asset($image->url) }}" alt="Image" style="max-width: 150px; height: auto;">
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('list.edit', ['id' => $post->id]) }}" method="GET" style="display: inline;">
                        @csrf
                        <button type="submit">編集</button>
                    </form>

                    <form action="{{ route('list.delete') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <button type="submit">削除</button>
                    </form>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection