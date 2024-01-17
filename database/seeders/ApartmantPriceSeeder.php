<?php

namespace Database\Seeders;

use App\Models\ApartmantPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmantPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($apartmentId = 1; $apartmentId <= 24; $apartmentId++) {
            for ($i = 1; $i <= 5; $i++) {
                ApartmantPrice::create([
                    'apartmant_id' => $apartmentId,
                    'price' => rand(80, 150), 
                    'start_date' => now()->addDays($i * 10)->toDateString(),
                    'end_date' => now()->addDays(($i + 1) * 10)->toDateString(),
                ]);
            }
        }
    }
}
