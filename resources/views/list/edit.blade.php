@extends('layouts.app')

@section('title', 'リスト編集')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2>リスト編集</h2>
            <form action="{{ route('list.update', ['id' => $listpage->id]) }}" method="post" enctype="multipart/form-data">
                @method('PUT') {{-- 更新処理を行うためにPUTメソッドを指定 --}}
                @csrf

                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif

                <div class="form-group row">
                    <label class="col-md-3">リスト / アルバム</label>
                    <select name="list_log" id="list_log" class="form-control">
                        <option value="0" {{ $listpage->list_log == 0 ? 'selected' : '' }}>リスト</option>
                        <option value="1" {{ $listpage->list_log == 1 ? 'selected' : '' }}>アルバム</option>
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">都道府県</label>
                    <select name="prefecture_id" id="prefecture">
                        @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}" {{ $prefecture->id == $listpage->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->area }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">カテゴリ</label>
                    <select name="category_id" id="category">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $listpage->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">タイトル</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ old('title', $listpage->title) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">本文</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="body" rows="20">{{ old('body', $listpage->body) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">画像</label>
                    <div class="col-md-10">
                        <p>選択中の画像:</p>
                        @foreach($listpage->images as $image)
                        <img src="{{ asset($image->url) }}" alt="image" class="img-thumbnail" width="50">
                        <a href="{{ asset($image->url) }}" target="_blank">{{ basename($image->url) }}</a>
                        <label>
                            <input type="checkbox" name="remove[]" value="{{ $image->id }}"> 画像を削除
                        </label>
                        <br>
                        @endforeach

                        @php
                        // 現在の画像枚数
                        $currentImageCount = $listpage->images->count();
                        // 新しくアップロードできる枠（最大8 - 現在の画像数）
                        $uploadableCount = max(0, 8 - $currentImageCount);
                        @endphp

                        <p>新しい画像を選択:</p>
                        @for($i = 0; $i < $uploadableCount; $i++) <input type="file" class="form-control-file" name="images[]">
                            @endfor
                    </div>
                </div>

                <!-- <p>現在の画像:</p>
                        @foreach($listpage->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="image" class="img-thumbnail" width="100">
                        <label>
                            <input type="checkbox" name="remove" value="true"> 画像を削除
                        </label>
                        @endforeach
                        <p>新しい画像を選択:</p>
                        @for($i = 0; $i < 9; $i++) <input type="file" class="form-control-file" name="images[]">
                            @endfor
                    </div>
                </div> -->

                <input type="submit" class="btn btn-primary" value="更新">
            </form>
        </div>
    </div>
</div>

@endsection