<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
            'name' => "post/1/b9ONGcUjcFt2SJcNcuIU_20210111161812.png",
            'type' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => "post/1/DlemYCPzTfAGIPDxVUOK_20210111161812.jpg",
            'type' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => "post/1/rAM0AAw2Udx1c2BT6ciY_20210111161811.png",
            'type' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => "post/2/4OqRNrhhtak42lfplHds_20210112003242.mp4",
            'type' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => "9MjAJSoaoSo",
            'type' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
        ]);
    }
}
