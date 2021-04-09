
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateUsersTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("users", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->string('name')->comment('ユーザー名'); //ユーザー名
						$table->string('email')->comment('メールアドレス')->nullable();  //メールアドレス
						$table->timestamp('email_verified_at')->comment('メール認証')->nullable(); //メール認証
						$table->string('password')->comment('パスワード')->nullable(); //パスワード
						$table->string('provider')->comment('SNS識別')->nullable(); //SNS識別
						$table->string('provider_id')->comment('SNSのID')->nullable(); //パスワード
						$table->string('remember_token',100)->comment('ログイン保持')->nullable();  //ログイン保持
						$table->integer('age')->comment('年齢')->nullable(); //年齢
						$table->integer('published_age_flg')->comment('0:年齢公開 1：非公開')->nullable()->default(1); //0:年齢公開 1：非公開
						$table->integer('prefecture_id')->comment('都道府県区分')->nullable(); //都道府県区分
						$table->integer('published_prefecture_flg')->comment('0:都道府県公開： 1:非公開')->nullable()->default(1); //0:都道府県公開： 1:非公開
						$table->text('introduction')->comment('自己紹介文')->nullable(); //自己紹介文
						$table->string('thumbnail')->comment('サムネイル画像パス')->nullable(); //サムネイル画像パス
						$table->softDeletes(); //削除フラグ
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
                Schema::dropIfExists("users");
            }
        }
    