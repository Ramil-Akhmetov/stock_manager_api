<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.read']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.delete']);

        Permission::create(['name' => 'categories.create']);
        Permission::create(['name' => 'categories.read']);
        Permission::create(['name' => 'categories.update']);
        Permission::create(['name' => 'categories.delete']);

        Permission::create(['name' => 'items.create']);
        Permission::create(['name' => 'items.read']);
        Permission::create(['name' => 'items.update']);
        Permission::create(['name' => 'items.delete']);
    }
}
