<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    $updated_at = $faker->dateTimeThisYear('now', 'PRC');
    return [
        'title' => $faker->sentence(),
        'body' => $faker->text(),
        'user_id' => $faker->randomDigitNotNull,
        'category_id' => $faker->numberBetween(1, 4),
        'view_count' => $faker->randomNumber(3),
        'excerpt' => $faker->sentence(),
        'updated_at' => $updated_at,
        'created_at' => $faker->dateTimeThisYear($updated_at, 'PRC'),
    ];
});
