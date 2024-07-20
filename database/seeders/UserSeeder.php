<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 1,
            'password' => Hash::make('secret'),
        ]);

        User::factory()->create([
            'name' => 'guru',
            'username' => 'guru',
            'email' => 'guru@admin.com',
            'role' => 2,
            'password' => Hash::make('secret'),
        ]);
    }
}
