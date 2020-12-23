<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    $time = $faker->dateTimeThisMonth();
    return [
        'topic_id' => $faker->numberBetween(1, 99),
        'user_id' => $faker->numberBetween(1, 9),
        'content' => $faker->sentence(9),
        'created_at' => $time,
        'updated_at' => $time
    ];
});
