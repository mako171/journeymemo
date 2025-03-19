@extends('layouts.app')

@section('title', '新規作成')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>候補リスト/アルバムの新規作成</h2>
            <form action="{{ route('list.store') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row my-3">
                    <label class="col-md-4 form-container">リスト / アルバム</label>
                    <select name="list_log" id="list_log" class="form-control">
                        <option value="0">リスト</option>
                        <option value="1">アルバム</option>
                    </select>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">都道府県</label>
                    <select name="prefecture_id" id="prefecture" style="height: 35px;">
                        @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}">{{ $prefecture->area }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">カテゴリ</label>
                    <select name="category_id" id="category" style="height: 35px;">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">タイトル</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">本文</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 form-container">画像</label>
                    <div class="col-md-10">
                        @for($i = 0; $i < 8; $i++) <input type="file" class="form-control-file" name="images[]">
                            @endfor
                    </div>
                </div>
                @csrf
                <input type="submit" class="btn btn-primary" value="作成">
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #4dd0e173;
        /* 背景色 */
    }
</style>

<script>

</script>
@endsection