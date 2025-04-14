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

        <div class="swiper imageSwiper d-none d-md-block" style="width: 100%; padding: 0px 0px 20px 0px;">
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
            <div class="title-row">
                <h2 class="title-text">
                    <strong>{{ $type === 'list' ? '候補リスト' : 'アルバム' }}（{{ $prefectureName }}）</strong>
                </h2>
                <div class="button-group">
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

            <div class="thick-line mb-4 mt-1">
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