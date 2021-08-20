
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateFollowsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("follows", function (Blueprint $table) {

						$table->increments('id');
						$table->integer('user_id');
						$table->integer('follow_user_id'); //フォローしたuser_id
						$table->timestamps(); //作成日時

                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists("follows");
            }
        }
    