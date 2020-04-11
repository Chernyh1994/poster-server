<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [];
        for($i = 1; $i <= 10; $i++ ) {
            $authorId = ($i > 5) ? 1 : 2;
            $posts[] = [
                'title' => Str::random(10),
                'description' => Str::random(100),
                'author_id' => $authorId,
            ];
        }

        DB::table('posts')->insert($posts);
    }
}
