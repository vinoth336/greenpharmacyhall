<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\States;
use Faker\Generator as Faker;

$factory->define(States::class, function (Faker $faker) {
    return [
        'state'=>$faker->state
    ];
});
