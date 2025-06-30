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
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');//bigIntkey=主キーを表している
            $table->unsignedBigInteger('user_id');//外部キー
            $table->date('date')->comment('日付');
            $table->string('school_category')->comment('昼スクールor夜スクール');
            $table->dateTime('start_time')->nullable()->comment('開始時間');
            $table->dateTime('end_time')->nullable()->comment('終了時間');
            $table->string('location')->nullable()->comment('勤務場所');
            $table->timestamps();

            // 外部キー制約（users テーブルがある場合）
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
};
