<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'id' => rand(1,100000000),
        'title' => $faker->title(),
        'body' => $faker->text(),
        'social_media_id' => 1
    ];
});
