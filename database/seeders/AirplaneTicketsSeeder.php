<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AirplaneTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('airplane_tickets')->insert([
                'ticket_type' => $faker->randomElement(['one_way', 'return']),
                'from_destination' => $faker->city,
                'to_destination' => $faker->city,
                'departure_date' => $faker->date,
                'return_date' => $faker->date,
                'adults' => $faker->numberBetween(0, 5),
                'children' => $faker->numberBetween(0, 3),
                'babies' => $faker->numberBetween(0, 2),
                'class' => $faker->randomElement(['economy', 'business', 'first_class']),
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
