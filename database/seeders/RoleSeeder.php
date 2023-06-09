<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super-Admin']);

        $role = Role::create(['name' => 'Admin']);

        $role->givePermissionTo('users.create');
        $role->givePermissionTo('users.read');
        $role->givePermissionTo('users.update');
        $role->givePermissionTo('users.delete');

        $role->givePermissionTo('categories.create');
        $role->givePermissionTo('categories.read');
        $role->givePermissionTo('categories.update');
        $role->givePermissionTo('categories.delete');

        $role->givePermissionTo('items.create');
        $role->givePermissionTo('items.read');
        $role->givePermissionTo('items.update');
        $role->givePermissionTo('items.delete');
    }
}
