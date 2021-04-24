<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->integer('mail_notice_flg')->default(1)->comment('メール通知 0:受け取らない 1:受け取る');
            $table->integer('comment_flg')->default(1)->comment('詳細設定(コメント通知) 0:受け取らない 1:受け取る');
            $table->integer('message_flg')->default(1)->comment('詳細設定(メッセージ通知) 0:受け取らない 1:受け取る');
            $table->integer('partner_flg')->default(1)->comment('詳細設定(相方申請通知) 0:受け取らない 1:受け取る');
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
        Schema::dropIfExists('mail_notices');
    }
}
