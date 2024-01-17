<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            AdminUserSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            ResortTypeSeeder::class,
            ResortSeeder::class,
            ApartmentSeeder::class,
            ApartmantPriceSeeder::class,
            ContactUsSeeder::class,
            AirplaneTicketsSeeder::class,
            SubscriberSeeder::class,
        ]);
        \App\Models\User::factory(2)->create();
        



    }
}
