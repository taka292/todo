<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id(); //idを1から連番にするためにはSET @i := 0;UPDATE テーブル名 SET カラム名 = (@i := @i +1);に指定する。
            $table->string('title'); // todoのタイトルを保存するカラム
            $table->timestamps();
            // $table->is_complete();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
