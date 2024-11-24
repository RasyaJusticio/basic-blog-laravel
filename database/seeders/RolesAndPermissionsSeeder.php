<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    private array $PERMISSIONS;
    private array $ROLES;

    public function __construct()
    {
        $this->PERMISSIONS = [
            'access-dashboard'
        ];

        $this->ROLES = [
            'admin' => ['access-dashboard'],
            'author' => ['access-dashboard'],
            'user' => ['']
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->PERMISSIONS as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($this->ROLES as $role => $permissions) {
            $role = Role::create(['name' => $role]);
            $role->syncPermissions($permissions);
        }
    }
}
