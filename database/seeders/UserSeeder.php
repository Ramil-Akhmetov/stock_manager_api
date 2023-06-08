<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@email.com',
        ]);
//        $user->assignRole('Super-Admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
        ]);
//        $user->assignRole('Admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@email.com',
        ]);
    }
}
