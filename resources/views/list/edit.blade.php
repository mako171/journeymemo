@extends('layouts.front')

@section('title', 'リスト/アルバム編集')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h2><strong>候補リスト/アルバムの編集</strong></h2>
            <form action="{{ route('list.update', ['id' => $listpage->id]) }}" method="post" enctype="multipart/form-data">
                @method('PUT') {{-- 更新処理を行うためにPUTメソッドを指定 --}}
                @csrf

                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <div class="error-message">
                        <li>{{ $e }}</li>
                    </div>
                    @endforeach
                </ul>
                @endif

                <div class="form-group row my-3">
                    <label class="col-md-4 form-container">リスト / アルバム</label>
                    <select name="list_log" id="list_log" class="form-control">
                        <option value="0" {{ $listpage->list_log == 0 ? 'selected' : '' }}>リスト</option>
                        <option value="1" {{ $listpage->list_log == 1 ? 'selected' : '' }}>アルバム</option>
                    </select>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">都道府県</label>
                    <select name="prefecture_id" id="prefecture" style="height: 35px;">
                        @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}" {{ $prefecture->id == $listpage->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->area }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">カテゴリ</label>
                    <select name="category_id" id="category" style="height: 35px;">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $listpage->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">タイトル</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="title" value="{{ old('title', $listpage->title) }}">
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-md-4 form-container">本文</label>
                    <div class="col-md-12">
                        <textarea class="form-control" name="body" rows="20">{{ old('body', $listpage->body) }}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <!-- <label class="col-md-4 form-container">画像</label> -->
                    <div class="col-md-10">
                        <strong>🔴選択中の画像</strong>
                        @php $imageIndex = 1; @endphp

                        @foreach($listpage->images as $image)
                        <div class="mb-2">
                            <label><strong>画像{{ $imageIndex }} : </strong></label>
                            <!-- <br> -->
                            <img src="{{ asset($image->url) }}" alt="image" class="img-thumbnail" width="50">
                            <a href="{{ asset($image->url) }}" target="_blank">{{ basename($image->url) }}</a>
                            <br>
                            <label>
                                <input type="checkbox" name="remove[]" value="{{ $image->id }}"> 画像を削除
                            </label>
                            <hr color="#c0c0c0">
                            @php $imageIndex++; @endphp
                            @endforeach

                            @php
                            // 現在の画像枚数
                            $currentImageCount = $listpage->images->count();
                            // 新しくアップロードできる枠（最大9 - 現在の画像数）
                            $uploadableCount = max(0, 9 - $currentImageCount);
                            @endphp

                            <br>
                            <strong>🔴新しい画像を選択</strong>
                            @for($i = 0; $i < $uploadableCount; $i++) <!-- <input type="file" class="form-control-file" name="images[]"> -->
                                <div class="mb-2">
                                    <label for="image{{$i}}"><strong>画像{{$imageIndex}} : </strong></label>
                                    <input type="file" class="form-control-file" name="images[]" id="image{{$i}}">
                                </div>
                                @php $imageIndex++; @endphp
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

                    <br>
                    <input type="submit" class="btn btn-danger" value="更新">
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #fbe9e78a;
    }
</style>
@endsection