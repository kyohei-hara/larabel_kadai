<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineMember;
use Faker\Generator as Faker;

$factory->define(OnlineMember::class, function (Faker $faker) {
    return [
        //
        'MEMBER_NO'=> 00000000001,
        'PASSWORD'=> "pass1",
        'NAME'=> $faker->unique()->name,
        'AGE'=> 20,
        'TEL'=> "00000000000",
        'SEX'=> "2",
        'ZIP'=>$faker->postcode,
        'ADDRESS'=>$faker->address,
        'REGISTER_DATE'=> new DateTime(),
    ];
});