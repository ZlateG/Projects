<?php

namespace Database\Seeders;

use App\Models\Resort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resort::create([
            'city_id' => 1,
            'resort_type' => 1,
            'resort_name' => 'Бела',
            'priority' => 1,
            'resort_description' => 'Опис за ресорт Бела',
        ]);
        Resort::create([
            'city_id' => 1,
            'resort_type' => 1,
            'priority' => 2,
            'resort_name' => 'Мала',
            'resort_description' => 'Опис за ресорт Мала',
        ]);
        Resort::create([
            'city_id' => 1,
            'resort_type' => 1,
            'priority' => 3,
            'resort_name' => 'Црна',
            'resort_description' => 'Опис за ресорт Црна',
        ]);
        Resort::create([
            'city_id' => 1,
            'resort_type' => 1,
            'priority' => 4,
            'resort_name' => 'Наша',
            'resort_description' => 'Опис за ресорт Наша',
        ]);
        Resort::create([
            'city_id' => 1,
            'resort_type' => 1,
            'priority' => 5,
            'resort_name' => 'Мариа',
            'resort_description' => 'Опис за ресорт Мариа',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 1,
            'resort_name' => 'Бела',
            'resort_description' => 'Опис за ресорт Бела',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 2,
            'resort_name' => 'Антигона',
            'resort_description' => 'Опис за ресорт Антигона',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 3,
            'resort_name' => 'ДЕ ЛУКС',
            'resort_description' => 'Опис за ресорт ДЕ ЛУКС',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 4,
            'resort_name' => 'ФИЛЕМИ',
            'resort_description' => 'Опис за ресорт ФИЛЕМИ',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 5,
            'resort_name' => 'КАЛЕ',
            'resort_description' => 'Опис за ресорт КАЛЕ',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 6,
            'resort_name' => 'МАГДАЛЕНА',
            'resort_description' => 'Опис за ресорт МАГДАЛЕНА',
        ]);
        Resort::create([
            'city_id' => 5,
            'resort_type' => 1,
            'priority' => 7,
            'resort_name' => 'МЕСОКАСТРО',
            'resort_description' => 'Опис за ресорт МЕСОКАСТРО',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 1,
            'resort_name' => 'Бела',
            'resort_description' => 'Опис за ресорт Бела',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 2,
            'resort_name' => 'Антигона',
            'resort_description' => 'Опис за ресорт Антигона',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 3,
            'resort_name' => 'ДЕ ЛУКС',
            'resort_description' => 'Опис за ресорт ДЕ ЛУКС',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 4,
            'resort_name' => 'ФИЛЕМИ',
            'resort_description' => 'Опис за ресорт ФИЛЕМИ',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 5,
            'resort_name' => 'КАЛЕ',
            'resort_description' => 'Опис за ресорт КАЛЕ',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 6,
            'resort_name' => 'МАГДАЛЕНА',
            'resort_description' => 'Опис за ресорт МАГДАЛЕНА',
        ]);
        Resort::create([
            'city_id' => 6,
            'resort_type' => 1,
            'priority' => 7,
            'resort_name' => 'МЕСОКАСТРО',
            'resort_description' => 'Опис за ресорт МЕСОКАСТРО',
        ]);

 
    }
}
