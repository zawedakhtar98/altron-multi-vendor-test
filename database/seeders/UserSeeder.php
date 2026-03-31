<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash as FacadesHash;

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
                'email' => 'customer@gmail.com',
                'password' => FacadesHash::make('customer'), // Ensure to hash the password
                'role' => 'customer', 
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => FacadesHash::make('admin'), // Ensure to hash the password
                'role' => 'admin', 
            ],
            [
                'name' => 'Seller1',
                'email' => 'seller1@gmail.com',
                'password' => FacadesHash::make('seller1'), // Ensure to hash the password
                'role' => 'seller',
            ],
            [
                'name' => 'Seller2',
                'email' => 'seller2@gmail.com',
                'password' => FacadesHash::make('seller2'), // Ensure to hash the password
                'role' => 'seller',
            ]
        ]);
    }
}
