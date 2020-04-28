<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [];
        for($i = 1; $i <= 30; $i++ ) {
            $authorId = ($i > 5) ? 1 : 2;
            $postId = rand(1,10);
            $parentId = ($i > 10) ? rand(1,10) : null;
            $comments[] = [
               'content' => Str::random(20),
               'post_id' => $postId,
               'parent_id' => $parentId,
               'author_id' => $authorId,
            ];
        }

        DB::table('comments')->insert($comments);
    }
}
