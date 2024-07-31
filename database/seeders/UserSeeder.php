<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or find the user with the given email
        $user1 = User::firstOrCreate(
            ['email' => 'tony1@gmail.com'],
            [
                'name' => 'Tony',
                'password' => Hash::make('password'),
            ]
        );

        // Create or find another user with the given email
        $user2 = User::firstOrCreate(
            ['email' => 'abdulla@gmail.com'],
            [
                'name' => 'Abdullajon',
                'password' => Hash::make('password'),
            ]
        );

        // Attach roles to the users
        $user1->roles()->attach([1, 3]);
        $user2->roles()->attach([2]);
    }
}
