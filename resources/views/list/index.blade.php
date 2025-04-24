@extends('layouts.front')

@section('title', 'リスト/アルバム')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/front.css') }}">
<link rel="stylesheet" href="{{ asset('css/list_log.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="swiper imageSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="image-wrapper">
                        <img src="/storage/images/3cJ5BPMV0jth5lVUEFCwpRHHp1ZgRT72wzLG99YC.jpg" class="img-fluid rounded" alt="Slide 1 american village">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="image-wrapper">
                        <img src="/storage/images/9tQNW35g9V7ynprjGSAI2YkVrXTkReNgfw0EzXoa.jpg" class="img-fluid rounded" alt="Slide 2 ishikawa">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="image-wrapper">
                        <img src="/storage/images/kEBfA8x0YMEhuUngswsHWeSNllRJIiGjtg1yMKSG.jpg" class="img-fluid rounded" alt="Slide 3 hiroshima">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="image-wrapper">
                        <img src="/storage/images/zTvm52JjEGMx0QDLWNqQW2XhYOtZ4BZQXQDI9ONs.jpg" class="img-fluid rounded" alt="Slide 4 okinawa">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="image-wrapper">
                        <img src="/storage/images/2ElhHqub069TukyiD1eYQadvnrCBBLoOXQvE0M5A.jpg" class="img-fluid rounded" alt="Slide 5 kagoshima">
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-9 mx-auto">
            <h2 class="title-text mt-3">
                <strong>{{ $type === 'list' ? '候補リスト' : 'アルバム' }}（{{ $prefectureName }}）</strong>
            </h2>
            <div class="thick-line mt-1">
            </div>

            <div class="title-row mb-4">
                <div class="weather-info d-flex mb-3">
                    <!-- <div class="weather-info">
                    @if (is_array($weather) && isset($weather['main']['temp']))
                    <p>天気 : {{ $weather['weather'][0]['description'] }}</p>
                    <p>気温 : {{ $weather['main']['temp'] }}℃</p>
                    <p>湿度 : {{ $weather['main']['humidity'] }}%</p>
                    @else
                    <p>気温情報が取得できませんでした</p>
                    @endif
                </div> -->
                    @if (is_array($weather) && isset($weather['weather'][0]))
                    @php
                    $weatherId = $weather['weather'][0]['id'];
                    $main = $weather['weather'][0]['main'];
                    $description = $weather['weather'][0]['description'];
                    $icon = $weather['weather'][0]['icon'];
                    $temp = $weather['main']['temp'] ?? null;
                    $humidity = $weather['main']['humidity'] ?? null;
                    $iconUrl = "https://openweathermap.org/img/wn/{$icon}@2x.png";

                    $category = match (true) {
                    $weatherId >= 200 && $weatherId < 300=> '雷雨',
                        $weatherId >= 300 && $weatherId < 400=> '霧雨',
                            $weatherId >= 500 && $weatherId < 600=> '雨',
                                $weatherId >= 600 && $weatherId < 700=> '雪',
                                    $weatherId >= 700 && $weatherId < 800=> '大気（霧など）',
                                        $weatherId === 800 => '晴れ',
                                        $weatherId > 800 => '曇り',
                                        default => '不明',
                                        };
                                        @endphp

                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{ $iconUrl }}" alt="天気アイコン" style="width: 50px; height: 50px;">
                                            <div>
                                                <div class="d-flex flex-row flex-wrap gap-4">
                                                    <p class="mb-1">天気：{{ $category }}（{{ $description }}）</p>
                                                    <p class="mb-1">気温：{{ $temp }}℃</p>
                                                    <p class="mb-0">湿度：{{ $humidity }}%</p>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <p>気象情報が取得できませんでした</p>
                                        @endif
                </div>

                <div class="button-group mt-1">
                    <a href="{{ route('list.index', ['type' => 'list', 'prefecture_id' => $prefectureId]) }}" class="btn {{ $type === 'list' ? 'btn-primary' : 'btn-outline-primary' }}">
                        リスト
                    </a>
                    <a href="{{ route('list.index', ['type' => 'album', 'prefecture_id' => $prefectureId]) }}" class="btn {{ $type === 'album' ? 'btn-danger' : 'btn-outline-danger' }}">
                        アルバム
                    </a>
                    <!-- <a href="{{ route('list.create') }}" class="btn btn-outline-secondary">新規作成</a>
                <a href="{{ route('top.top') }}" class="btn btn-outline-danger">トップページ</a>
                <div>
                    <a href="{{ route('top.search') }}" class="btn btn-dark">検索</a>
                </div> -->
                </div>
            </div>

            @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-header list-title-color">
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

                    <div id="imageModal" class="modal" style="display:none;">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="modalImage">
                    </div>

                    @endif
                    <div class="mt-2">
                        <div class="button-container">
                            <form action="{{ route('list.edit', ['id' => $post->id]) }}" method="GET" style="display: inline;">
                                @csrf
                                <button type="submit" class="list-edit-button">編集</button>
                            </form>

                            <form action="{{ route('list.delete') }}" method="POST" style="display: inline;">
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
</div>

<style>
    body {
        background-color: #fff9c494;
    }
</style>

<script>
    const swiper = new Swiper(".imageSwiper", {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 20,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        speed: 800, // スライド速度（ミリ秒）
    });

    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        const closeBtn = document.querySelector(".close");

        document.querySelectorAll(".post-image").forEach(img => {
            img.style.cursor = "pointer";
            img.addEventListener("click", function() {
                modal.style.display = "block";
                modalImg.src = this.src;
            });
        });

        closeBtn.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    });
</script>
@endsection