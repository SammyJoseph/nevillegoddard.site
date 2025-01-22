<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $super = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $writer = Role::create(['name' => 'writer']);
        $user = Role::create(['name' => 'user']);

        // Asignar permisos a roles
        $super->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'manage users',
        ]);

        $writer->givePermissionTo([
            'create articles',
            'edit articles',
            'view articles',
        ]);
    }
}
