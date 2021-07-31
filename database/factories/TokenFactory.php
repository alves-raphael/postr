<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Token;
use Faker\Generator as Faker;
use App\TokenType;

$factory->define(Token::class, function (Faker $faker) {
    return [
        'id' => rand(1,10000),
        'token' => uniqid() . uniqid(),
        'social_media_id' => 1,
        'token_type_id' => TokenType::USER_ACCESS
    ];
});
