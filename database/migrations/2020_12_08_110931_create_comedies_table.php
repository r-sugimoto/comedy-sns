
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateComediesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("comedies", function (Blueprint $table) {

						$table->increments('id');
						$table->string('name')->nullable(); //コンビ名
						$table->softDeletes();
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
                Schema::dropIfExists("comedies");
            }
        }
    