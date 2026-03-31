<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $parentCat = Category::factory()->count(10)->create();
        // foreach($parentCat as $category){
        //     Category::factory()->count(5)->subCategory($category->id)->create();
        // }
        $this->call([
            // UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
