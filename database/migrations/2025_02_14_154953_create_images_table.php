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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // 画像の場所
            $table->unsignedBigInteger('listpage_id'); // リストID
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('listpage_id')
                ->references('id')->on('listpages')
                ->onDelete('cascade');  // リストページ削除時、関連画像も削除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
};
