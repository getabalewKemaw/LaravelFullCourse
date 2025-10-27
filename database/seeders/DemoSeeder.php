<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->count(5)->create()->each(function($product) {
            $product->reviews()->createMany([
                ['user_name'=>'Alice','comment'=>'Nice product','rating'=>5],
                ['user_name'=>'Bob','comment'=>'Worked fine','rating'=>4],
            ]);
        });
    }
}
