<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Vessel;
use Faker\Generator as Faker;

$factory->define(Vessel::class, function (Faker $faker) {
    return [
        'code'=> $faker->regexify('[A-Z]{4,3}'),
        'name'=>$faker->name,
    ];
});
