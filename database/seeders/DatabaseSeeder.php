<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'SuperAdmin' => [
                'create admin',
                'list url all'
            ],
            'Admin' => [
                'create admin',
                'create member',
                'create url',
                'list url company'
            ],
            'Member' => [
                'create url',
                'list url personal'
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            }

            Role::create(['name' => $roleName])->syncPermissions($permissions);
        }

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('superadmin@123')
        ])->assignRole('SuperAdmin');
    }
}
