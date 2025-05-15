<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->numerify('09########'),
                'address' => $faker->address,
                'birth_day' => $faker->date('Y-m-d', '2005-01-01'),
                'registration_date' => $faker->dateTimeBetween('-1 years', 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customer')->insert($data);
    }
}
