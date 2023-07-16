<?php

namespace Database\Seeders;

use App\Models\TempOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TempOrder::factory(3)->create();
    }
}
