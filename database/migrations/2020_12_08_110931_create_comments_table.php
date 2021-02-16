
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateCommentsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("comments", function (Blueprint $table) {

						$table->increments('id');
						$table->bigInteger('user_id');
						$table->integer('post_id');
						$table->text('message')->nullable(); //コメント内容
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
                Schema::dropIfExists("comments");
            }
        }
    