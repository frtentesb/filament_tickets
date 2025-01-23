<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Sistema',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'document_number' => '985.155.124-72',
            'telephone' => '(11) 99999-9999',
            'is_admin' => true,
            'password' =>  Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        User::factory()->create([
            'name' => 'User Sistema',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'document_number' => '000.222.124-72',
            'telephone' => '(11) 99999-9999',
            'is_admin' => false,
            'password' =>  Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
