<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Orus\Server::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'ip_address' => $faker->ipv4,
        'ram_size' => random_int(1, 16),
        'sudo_password' => str_random(30),
        'ssh_port' => 22,
        'user_id' => function() {
            return factory('Orus\User')->create()->id;
        }
    ];
});
