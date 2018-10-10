<?php

use Faker\Generator as Faker;

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'comment_id'=>$faker->numberBetween(1,1000),
        'user_id'=>$faker->numberBetween(31,48),
        'body'=> $faker->paragraph(1),
        'approved'=>1,
        'approved_by'=>$faker->randomElement(['51','52','48']),
    ];
});
