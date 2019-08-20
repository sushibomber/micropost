<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('micropost_id')->unsigned()->index();  //integerは整数に限る　unsignedで正の整数を指定　index：辞書の目次のｲﾒｰｼﾞ。DB内のデータを探す速度がアップする
            $table->string('img_path');    //stringは文字列
            $table->timestamps();    //timestampは、データタイム型になる
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures');
    }
}
