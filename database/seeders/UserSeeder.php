<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Plantora',
                'last_name' => 'Admin',
                'email' => 'admin@plantora.com',
                'phone' => '+92 300 0000000',
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Customer',
                'email' => 'customer@plantora.com',
                'phone' => '+92 300 1111111',
                'role' => 'customer',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Green Roots',
                'last_name' => 'Nursery',
                'email' => 'nursery@plantora.com',
                'phone' => '+92 300 2222222',
                'role' => 'nursery_owner',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Content',
                'last_name' => 'Editor',
                'email' => 'editor@plantora.com',
                'phone' => '+92 300 3333333',
                'role' => 'editor',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Garden',
                'last_name' => 'Author',
                'email' => 'author@plantora.com',
                'phone' => '+92 300 4444444',
                'role' => 'author',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
