<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache role & permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat role
        $roles =  ['admin', 'manager', 'gudang', 'user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Buat user admin pertama
        $admin = User::firstOrCreate(
            ['email' => 'admin@deltamegahraya.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('password')]
        );
        $admin->assignRole('admin');
    }
}
