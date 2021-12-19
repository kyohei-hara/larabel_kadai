<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineProduct;
use Faker\Generator as Faker;

$factory->define(OnlineProduct::class, function (Faker $faker) {
    return [
        'MAKER' => $faker->company,
        'STOCK_COUNT' => 10,
        'REGISTER_DATE' =>new DateTime(),
        'UNIT_PRICE' => mt_rand(50, 3000),
        'MEMO' => $faker->realText(50),
        'DELETE_FLG' => 0,
    ];
});

$factory->state(OnlineProduct::class, 'snack', function () {
    $num = mt_rand(100000, 999999);
    return [
        'PRODUCT_CODE' =>'001-'. $num .'-001',
        'CATEGORY_ID' => 1,
        'PRODUCT_NAME' => 'スナック'. $num,
        'PICTURE_NAME' => '/resources/images/snack.jpg',
    ];
});

$factory->state(OnlineProduct::class, 'chocolate', function () {
    $num = mt_rand(100000, 999999);
    return [
        'PRODUCT_CODE' =>'002-'. $num .'-002',
        'CATEGORY_ID' => 2,
        'PRODUCT_NAME' => 'チョコレート'. $num,
        'PICTURE_NAME' => '/resources/images/chocolate.jpg',
    ];
});

$factory->state(OnlineProduct::class, 'candy', function () {
    $num = mt_rand(100000, 999999);
    return [
        'PRODUCT_CODE' =>'003-'. $num .'-003',
        'CATEGORY_ID' => 3,
        'PRODUCT_NAME' => 'キャンディー'. $num,
        'PICTURE_NAME' => '/resources/images/candy.jpg',
    ];
});