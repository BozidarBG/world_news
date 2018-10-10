<?php

use Faker\Generator as Faker;
use App\User;
use App\Category;

$factory->define(App\Article::class, function (Faker $faker) {

    $user=User::where('role_id', 4)->inRandomOrder()->first();
    $category=Category::inRandomOrder()->first();
    return [
        'user_id' =>$user->id,
        'category_id' =>$category->id ,
        'title' => $faker->sentence(random_int(3,6)),
        'body'=>$faker->paragraph(random_int(10,30)),
        'photo' => 'img/frontend/'.$faker->randomElement(['1.jpg','2.jpg', '3.jpg', '4.jpg','5.jpg', '6.jpg', '7.jpg','8.jpg', '9.jpg', '10.jpg','11.jpg','12.jpg','13.jpg','14.jpg','15.jpg','16.jpg',]),
        'draft'=>0,
        'approved'=>'1',
        'approved_by'=>$faker->randomElement(['1','2']),
    ];
});

