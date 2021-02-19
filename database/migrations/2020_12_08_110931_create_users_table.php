
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
						$table->string('name'); //ユーザー名
						$table->string('email');
						$table->timestamp('email_verified_at')->nullable(); //メール認証
						$table->string('password'); //パスワード
						$table->string('remember_token',100)->nullable();  //ログイン保持
						$table->integer('age')->nullable(); //年齢
						$table->integer('published_age_flg')->nullable()->default(1); //0:年齢公開 1：非公開
						$table->integer('prefecture_id')->nullable(); //都道府県区分
						$table->integer('published_prefecture_flg')->nullable()->default(1); //0:都道府県公開： 1:非公開
						$table->text('introduction')->nullable(); //自己紹介文
						$table->string('thumbnail')->nullable(); //サムネイル画像パス
						$table->softDeletes(); //削除フラグ
						$table->timestamps();
						$table->unique('email');

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
    