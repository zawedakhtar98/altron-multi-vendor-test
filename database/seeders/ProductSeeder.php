<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    //logic changes thats why it commented
    // $seller1 = \App\Models\User::where('name', 'Seller1')->first()->id;
    // $seller2 = \App\Models\User::where('name', 'Seller2')->first()->id;

    \App\Models\Product::insert(
        [
        ['name' => 'Product 1', 'price' => 100, 'stock' => 10, 'category_id'=>1],
        ['name' => 'Product 2', 'price' => 100, 'stock' => 10, 'category_id'=>2],
        ['name' => 'Product 3', 'price' => 100, 'stock' => 10, 'category_id'=>3],
        ['name' => 'Product 4', 'price' => 100, 'stock' => 10, 'category_id'=>11],
        ['name' => 'T-Shirt 1', 'price' => 100, 'stock' => 10, 'category_id'=>12],
        ['name' => 'T-Shirt 3', 'price' => 250, 'stock' => 5, 'category_id'=>10],
        ['name' => 'T-Shirt 4', 'price' => 200, 'stock' => 5, 'category_id'=>1],
        ['name' => 'T-Shirt 5', 'price' => 300, 'stock' => 5, 'category_id'=>13],
        ['name' => 'T-Shirt 6', 'price' => 400, 'stock' => 5, 'category_id'=>19],
        ['name' => 'T-Shirt 7', 'price' => 600, 'stock' => 5, 'category_id'=>20],
    ]);
}

}
