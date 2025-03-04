<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listpages', function (Blueprint $table) {
            $table->id();
            $table->integer('list_log'); // リストページかアルバムページの選択
            $table->integer('prefecture_id'); // 都道府県の選択
            $table->integer('category_id'); // カテゴリの選択
            $table->string('title'); // リストのタイトル
            $table->text('body')->nullable();  // リストの本文
            $table->integer('user_id'); // ユーザID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listpages');
    }
};
