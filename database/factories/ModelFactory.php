<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\user;


$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'api_token' => str_random(60),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Setting::class, function (Faker\Generator $faker) {
    return [
        'group' => $faker->randomElement(['general','mapbox','preferences']),
        'key' => $faker->word,
        'value' => $faker->sentence
    ];
});

$factory->define(App\Models\Map::class, function (Faker\Generator $faker) {

    $users = User::lists('id')->toArray();

    return [
        'user_id' => $faker->randomElement($users),

        'status' => $faker->randomElement(['public','public','public','private','private','disabled']),
        'name' => $faker->sentence(6),
        'description' => $faker->paragraph(2),

        'style' => $faker->randomElement(['cilv7wj9m00uxbim8zml4zdz3', 'cikedqlyp00bbkqlxe7kzopov']),
        'longitude' => 4.390819,
        'latitude' => 51.92696,
        'zoom' => $faker->numberBetween(8, 10),
        'pitch' => $faker->numberBetween(10, 50),
        'bearing' => $faker->numberBetween(20, 180),

        'views' => $faker->numberBetween(1,1000),
        'created_at' => $faker->dateTimeBetween('-2 year','-6 months'),
        'updated_at' => $faker->dateTimeBetween('-5 months','now')
    ];
});


$factory->define(App\Models\Source::class, function (Faker\Generator $faker) {

    return [
        'origin_type' => $faker->randomElement(['url', 'url', 'url', 'url', 'file', 'dropbox', 'gdrive']),
        'origin_url' => $faker->randomElement([null, $faker->url]),
        'origin_file' => $faker->randomElement([null, 'whatever.csv']),
        'origin_format' => $faker->randomElement(['csv', 'geojson']),
        'origin_size' => $faker->numberBetween(100000, 15000000),

        'name' => $faker->sentence(2),
        'description' => $faker->sentence(20),
        'web' => 'https://schiedam.dataplatform.nl/dataset/'.$faker->slug,

        'sync_status' => $faker->randomElement(['ready','ready','ready','ready','ready','queued','downloading','processing','disabled','disabled','error']),
        'sync_interval' => $faker->randomElement(['never', 'onchange', 'hourly', 'daily', 'weekly', 'monthly', 'yearly']),
        'synced_at' => $faker->dateTimeBetween('-1 month','-1 day'),
        'created_at' => $faker->dateTimeBetween('-2 year','-6 months'),
        'updated_at' => $faker->dateTimeBetween('-5 months','now')
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
    ];
});


