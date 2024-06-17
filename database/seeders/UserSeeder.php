<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = User::factory()->create([
        //     'name' => 'Super-Admin',
        //     'email' => 'superadmin@email.com',
        // ]);
        // $user->assignRole('Super-Admin');

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
        ]);
        $admin->assignRole('Администратор');

        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@email.com',
        ]);
        $user->assignRole('Ответственное лицо');

        $user = User::factory()->create([
            'name' => 'keeper',
            'email' => 'user2@email.com',
        ]);
        $user->assignRole('Кладовщик');

        User::factory(10)->create();
    }
}
