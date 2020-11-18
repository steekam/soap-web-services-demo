<?php

require_once __DIR__.'/vendor/autoload.php';
require_once 'constants.php';

use App\Models\Student;


$faker = Faker\Factory::create();

echo "Seeding 10 student records ... \n";
foreach(range(1, 10) as $_) {
    (new Student())->insert([
        "name" => $faker->name,
        "email" => $faker->safeEmail,
        "phone_number" => $faker->phoneNumber,
        "address" => $faker->address,
        "entry_points" => $faker->unique()->randomNumber(2)
    ]);
}
echo "Done :) \n";