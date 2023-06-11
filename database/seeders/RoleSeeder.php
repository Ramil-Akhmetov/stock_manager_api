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

        $role->givePermissionTo('types.create');
        $role->givePermissionTo('types.read');
        $role->givePermissionTo('types.update');
        $role->givePermissionTo('types.delete');

        $role->givePermissionTo('groups.create');
        $role->givePermissionTo('groups.read');
        $role->givePermissionTo('groups.update');
        $role->givePermissionTo('groups.delete');

        $role->givePermissionTo('rooms.create');
        $role->givePermissionTo('rooms.read');
        $role->givePermissionTo('rooms.update');
        $role->givePermissionTo('rooms.delete');

        $role->givePermissionTo('confirmations.create');
        $role->givePermissionTo('confirmations.read');
        $role->givePermissionTo('confirmations.update');
        $role->givePermissionTo('confirmations.delete');

        $role->givePermissionTo('customers.create');
        $role->givePermissionTo('customers.read');
        $role->givePermissionTo('customers.update');
        $role->givePermissionTo('customers.delete');
    }
}
