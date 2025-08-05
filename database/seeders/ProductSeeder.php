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
    $seller1 = \App\Models\User::where('name', 'Seller1')->first()->id;
    $seller2 = \App\Models\User::where('name', 'Seller2')->first()->id;

    \App\Models\Product::insert(
        [
        ['name' => 'Product 1', 'price' => 100, 'in_stock' => 10, 'seller_id' => $seller1,'image'=>'1754365498-68917e3a2b301.jpg'],
        ['name' => 'Product 2', 'price' => 100, 'in_stock' => 10, 'seller_id' => $seller1,'image'=>'1754365498-68917e3a2b301.jpg'],
        ['name' => 'Product 3', 'price' => 100, 'in_stock' => 10, 'seller_id' => $seller1,'image'=>'1754365498-68917e3a2b301.jpg'],
        ['name' => 'Product 4', 'price' => 100, 'in_stock' => 10, 'seller_id' => $seller1,'image'=>'1754365498-68917e3a2b301.jpg'],
        ['name' => 'T-Shirt 1', 'price' => 100, 'in_stock' => 10, 'seller_id' => $seller1,'image'=>'1754365498-68917e3a2b301.jpg'],
        ['name' => 'T-Shirt 3', 'price' => 200, 'in_stock' => 5, 'seller_id' => $seller2,'image'=>'1754365923-68917fe305a63.jpg'],
        ['name' => 'T-Shirt 4', 'price' => 200, 'in_stock' => 5, 'seller_id' => $seller2,'image'=>'1754365923-68917fe305a63.jpg'],
        ['name' => 'T-Shirt 5', 'price' => 200, 'in_stock' => 5, 'seller_id' => $seller2,'image'=>'1754365923-68917fe305a63.jpg'],
        ['name' => 'T-Shirt 6', 'price' => 200, 'in_stock' => 5, 'seller_id' => $seller2,'image'=>'1754365923-68917fe305a63.jpg'],
        ['name' => 'T-Shirt 7', 'price' => 200, 'in_stock' => 5, 'seller_id' => $seller2,'image'=>'1754365923-68917fe305a63.jpg'],
    ]);
}

}
