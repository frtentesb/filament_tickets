<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        User::factory()->create([
            'name' => 'User Sistema teste',
            'email' => 'users@example.com',
            'email_verified_at' => now(),
            'document_number' => '000.222.124-71',
            'telephone' => '(11) 99999-9999',
            'is_admin' => false,
            'password' =>  Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
