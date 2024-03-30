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
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
//            'account_id' => $account->id,
            'first_name' => 'Rogério',
            'last_name' => 'Nascimento',
            'email' => 'rogerio@example.com',
            'password' => 'roger@2014',
            'owner' => true,
        ]);
    }
}
