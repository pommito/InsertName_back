<?php

namespace Database\Seeders;

use App\Models\Revenue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RevenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 12) as $month) {
            Revenue::create([
                'id_user' => 1,
                'amount' => 1200 + $month,
                'year' => 2024,
                'month' => $month,
            ]);
        }
    }
}
