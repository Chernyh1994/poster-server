<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $posts = [];
        for($i = 1; $i <= 50; $i++ ) {
            $authorId = ($i > 10) ? 1 : 2;
            $posts[] = [
                'content' => $faker->realText(),
                'author_id' => $authorId,
            ];
        }

        DB::table('posts')->insert($posts);
    }
}
