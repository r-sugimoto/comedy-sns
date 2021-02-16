<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(Post_TagTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(Post_ProductTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(RecruitsTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(PrefecturesTableSeeder::class);
        $this->call(GenerationsTableSeeder::class);
    }
}
