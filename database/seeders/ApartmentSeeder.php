<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            for ($j = 1; $j <= 2; $j++) {
                Apartment::create([
                    'resort_id' => $i,
                    'apartment_name' => "Апартман {$j} од ресорт број {$i}",
                    'apartment_description' => "Опис за апартман број {$j} од ресорт број {$i}",
                ]);
            }
        }
    }
}
