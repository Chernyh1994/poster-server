<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', '-2 months');
    return [
        'content' => $faker->realText(rand(100,2000)),
        'author_id' => rand(1,2),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
