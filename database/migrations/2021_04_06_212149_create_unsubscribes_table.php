<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnsubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('回答者ユーザーID'); //回答者通知作成ユーザーID
            $table->text('reason')->comment('退会理由'); //退会理由
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
        Schema::dropIfExists('unsubscribes');
    }
}
