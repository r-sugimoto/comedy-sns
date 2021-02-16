<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            [
            'user_id' => 1,
            'post_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ]
        ]);
    }
}
