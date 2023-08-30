<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ItemCategorySeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(BusinessManagerSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(TempOrderSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(DetailSaleSeeder::class);
    }
}
