<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->comment('通知作成ユーザーID'); //通知作成ユーザーID
            $table->integer('to_user_id')->comment('通知送り先のユーザーID'); //通知送り先のユーザーID
            $table->integer('action_type')->comment('1:コメント 2:DM 3:相方申請'); //1:コメント 2:DM 3:相方申請
            $table->integer('check_flg')->default(0)->comment('0:無効 1:有効'); //0:無効 1:有効
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
        Schema::dropIfExists('notices');
    }
}
