<?php

use Faker\Generator as Faker;


$factory->define(App\Comment::class, function (Faker $faker) {

    return [
        'article_id'=>$faker->numberBetween(1,300),
        'user_id'=>$faker->numberBetween(31,48),
        'body'=> $faker->paragraph(2),
        'approved'=>1,
        'approved_by'=>$faker->randomElement(['51','52','48']),
    ];
});
