<?php

use Illuminate\Database\Seeder;
use App\Post;
Use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) { 
            $title = $faker->text(10);
            $newPost = new Post();

            $newPost->user_id = 1;
            $newPost->title = $title;
            $newPost->body = $faker->paragraph(3 ,true);
            $newPost->slug = Str::slug($title, '-');

            $newPost->save();
        }
    }
}
