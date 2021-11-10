<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        'id' => rand(1,10000),
        'title' => $faker->title(),
        'done' => rand(0,1),
        'order' => rand(1, 10000)
    ];
});
