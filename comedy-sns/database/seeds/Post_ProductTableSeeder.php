<?php

use Illuminate\Database\Seeder;

class Post_ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_product')->insert([
            [
            'post_id' => 1,
            'product_id' => 1,
            ],
            [
            'post_id' => 1,
            'product_id' => 2,
            ],
            [
            'post_id' => 1,
            'product_id' => 3,
            ],
            [
            'post_id' => 2,
            'product_id' => 4,
            ],
            [
            'post_id' => 3,
            'product_id' => 5,
            ],
        ]);
    }
}
