<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 10) as $index) {
            DB::table('contact_us')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->paragraph,
                'created_at' => $faker->dateTimeThisMonth,
                'updated_at' => $faker->dateTimeThisMonth,
            ]);
        }
    }
}
