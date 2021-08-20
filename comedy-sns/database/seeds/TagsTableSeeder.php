<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
            'name' => 'テストタグ',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ3',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ4',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ5',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ6',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ7',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ8',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テストタグ9',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
        ]);
    }
}
