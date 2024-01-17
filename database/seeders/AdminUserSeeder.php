<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Zlatko',
            'email' => 'zlatko@gmail.com',
            'password' => Hash::make('zlatko1234'),
            'role_id' => 1, 
            'status' => 1, 
        ]);
    }
}
