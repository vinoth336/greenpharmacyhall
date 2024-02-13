<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Cities::class, function (Faker $faker) {
    return [
        'state_id'=>'1',
        'city'=>$faker->city
    ];
});
