<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemCategory::create([
            'description' => 'Register new', 
            'created_by' => '1'
        ]);
        ItemCategory::factory(10)->create();
    }
}
