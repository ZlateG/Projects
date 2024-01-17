<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        City::create(['city_name' => 'Касандра', 'country_id' => 1]); //id=1
        City::create(['city_name' => 'Ситонија', 'country_id' => 1]); //id=2
        City::create(['city_name' => 'Лефкада', 'country_id' => 1]); //id=3
        City::create(['city_name' => 'Тасос', 'country_id' => 1]); //id=4
        City::create(['city_name' => 'Охрид', 'country_id' => 2]); //id=5
        City::create(['city_name' => 'Крушево', 'country_id' => 2]); //id=6
        City::create(['city_name' => 'Берово', 'country_id' => 2]); //id=7
        City::create(['city_name' => 'Маврово', 'country_id' => 2]); //id=8
        City::create(['city_name' => 'Струга', 'country_id' => 2]); //id=9
    }
}
