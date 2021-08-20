<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'テスト1',
            'email' => 'foo@example.com',
            'password' => bcrypt('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テスト2',
            'email' => 'foo2@example.com',
            'password' => bcrypt('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            [
            'name' => 'テスト3',
            'email' => 'foo3@example.com',
            'password' => bcrypt('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
        ]);
    }
}
