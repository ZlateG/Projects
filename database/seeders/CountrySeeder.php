<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Country::create(['country_name' => 'Грција']);
        Country::create(['country_name' => 'Македонија']);
        Country::create(['country_name' => 'Хрватска']);
        Country::create(['country_name' => 'Албанија']);
    }
}
