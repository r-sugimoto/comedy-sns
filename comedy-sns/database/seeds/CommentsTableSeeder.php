<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
            'user_id' => 2,
            'post_id' => 1,
            'message' => Str::random(100),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ]
        ]);
    }
}
