<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Fix the typo here
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'name' => 'sheik',
            'username' => 'sheik',
            'email' => 'sheik@gmail.com',
            'address' => 'alandur',
            'phone' => '9025263520',
            'password' => Hash::make('111111111'), // Fix the typo here
        ]);
    }
}
