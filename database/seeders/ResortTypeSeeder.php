<?php

namespace Database\Seeders;

use App\Models\ResortType;
use Illuminate\Database\Seeder;

class ResortTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ResortType::create(['type' => 'Хотел']);
        ResortType::create(['type' => 'Апартмани']);
    }
}
