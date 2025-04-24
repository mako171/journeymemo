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
        Schema::table('prefectures', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable()->after('area'); // 緯度
            $table->decimal('lon', 10, 7)->nullable()->after('lat');  // 経度
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prefectures', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lon']);
        });
    }
};
