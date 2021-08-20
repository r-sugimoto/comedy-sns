
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateRecruitsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("recruits", function (Blueprint $table) {

						$table->increments('id');
						$table->integer('prefecture_id')->nullable(); //募集都道府県
						$table->integer('generation_id')->nullable(); //募集世代
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
                Schema::dropIfExists("recruits");
            }
        }
    