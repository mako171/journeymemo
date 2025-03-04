{{-- layouts/app.blade.phpを読み込む --}}
@extends('layouts.app')

{{-- app.blade.phpの@yield('title')に'リスト新規作成'を埋め込む --}}
@section('title', 'リスト新規作成')

{{-- app.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2>候補リスト / アルバム 新規作成</h2>
            <form action="{{ route('list.store') }}" method="post" enctype="multipart/form-data">
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
                        <option value="0">リスト</option>
                        <option value="1">アルバム</option>
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">都道府県</label>
                    <select name="prefecture_id" id="prefecture">
                        @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}">{{ $prefecture->area }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">カテゴリ</label>
                    <select name="category_id" id="category">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">タイトル</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">本文</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">画像</label>
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
<script>

</script>
@endsection