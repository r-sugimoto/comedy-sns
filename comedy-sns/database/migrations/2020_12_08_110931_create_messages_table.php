
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMessagesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("messages", function (Blueprint $table) {

						$table->increments('id');
						$table->text('message')->nullable();
						$table->integer('room_id');
						$table->integer('user_id');
						$table->integer('partner_id')->nullable();
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
                Schema::dropIfExists("messages");
            }
        }
    