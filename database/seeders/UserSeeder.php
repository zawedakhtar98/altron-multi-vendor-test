<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Md Zawed',
                'email' => 'zawedakhtar98@gmail.com',
                'password' => Hash::make('customer'), // Ensure to hash the password
                'role' => 'customer', 
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'), // Ensure to hash the password
                'role' => 'admin', 
            ],
            [
                'name' => 'Seller1',
                'email' => 'seller1@gmail.com',
                'password' => Hash::make('seller1'), // Ensure to hash the password
                'role' => 'seller',
            ],
            [
                'name' => 'Seller2',
                'email' => 'seller2@gmail.com',
                'password' => Hash::make('seller2'), // Ensure to hash the password
                'role' => 'seller',
            ]
        ]);
    }
}
