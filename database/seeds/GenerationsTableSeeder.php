<?php

use Illuminate\Database\Seeder;

class GenerationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generations')->insert([
            ['name' => '10代後半'],
            ['name' => '20代前半'],
            ['name' => '20代後半'],
            ['name' => '30代前半'],
            ['name' => '30代後半'],
            ['name' => '40代'],
            ['name' => '50代以上'],
        ]);
    }
}
