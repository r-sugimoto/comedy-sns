
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreatePartnersTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("partners", function (Blueprint $table) {

						$table->increments('id');
						$table->integer('user_id');
						$table->integer('partner_user_id'); //申請先user_id
						$table->integer('application_flg'); //申請フラグ　0: 拒否 1:承認　
						$table->integer('comedy_id')->nullable();
						$table->text('message')->nullable();
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
                Schema::dropIfExists("partners");
            }
        }
    