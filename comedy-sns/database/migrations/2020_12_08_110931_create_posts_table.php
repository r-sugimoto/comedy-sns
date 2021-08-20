
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreatePostsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("posts", function (Blueprint $table) {

						$table->increments('id');
						$table->integer('user_id');
						$table->integer('recruit_id')->nullable(); //NULL:通常掲示板
						$table->text('title')->nullable(); //タイトル
						$table->text('message')->nullable(); //投稿内容
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
                Schema::dropIfExists("posts");
            }
        }
    