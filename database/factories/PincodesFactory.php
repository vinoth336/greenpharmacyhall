<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pincode;
use Faker\Generator as Faker;

$factory->define(Pincode::class, function (Faker $faker) {
    $postalCode = $faker->regexify('[0-9]{6}');

    return [
        'state_id'=>'1',
        'city_id'=>'1',
        'pincode'=>$postalCode
    ];
});
