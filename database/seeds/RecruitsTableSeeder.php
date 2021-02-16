<?php

use Illuminate\Database\Seeder;

class RecruitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recruits')->insert([
            [
            'prefecture_id' => 1,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 2,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 3,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 4,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 5,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 6,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 7,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 8,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 9,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 10,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'prefecture_id' => 11,
            'generation_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            ]);
    }
}
