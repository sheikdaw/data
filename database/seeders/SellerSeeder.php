<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Fix the typo here
use App\Models\Seller;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'sheik@gmail.com',
            'password' => Hash::make('111111111'), // Fix the typo here
        ]);
    }
}
