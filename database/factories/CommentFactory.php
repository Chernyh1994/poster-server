<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', '-2 months');
    return [
        'post_id' => rand(1,50),
        'parent_id' => (rand(1,50) > 10) ? null : rand(1,5),
        'content' => $faker->realText(rand(10,1000)),
        'author_id' => rand(1,2),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
