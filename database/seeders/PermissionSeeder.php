<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Dashboard']);
        Permission::create(['name' => 'Barang']);
        Permission::create(['name' => 'Barang Masuk']);
        Permission::create(['name' => 'Barang Keluar']);
        Permission::create(['name' => 'Report']);
        Permission::create(['name' => 'User Management']);

         //create roles and assign existing permissions
         $admin = Role::create(['name' => 'Admin']);
         $admin->givePermissionTo('Dashboard');
         $admin->givePermissionTo('Barang');
         $admin->givePermissionTo('Barang Masuk');
         $admin->givePermissionTo('Barang Keluar');
         $admin->givePermissionTo('Report');
         $admin->givePermissionTo('User Management');


         $karyawan = Role::create(['name' => 'Karyawan']);
         $karyawan->givePermissionTo('Dashboard');
         $karyawan->givePermissionTo('Barang');
         $karyawan->givePermissionTo('Barang Masuk');
         $karyawan->givePermissionTo('Barang Keluar');
         $karyawan->givePermissionTo('Report');

         // gets all permissions via Gate::before rule
         // create demo users
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('123')
        ]);
        $user->assignRole($admin);

        $user = User::factory()->create([
            'name' => 'Karyawan',
            'email' => 'karyawan@test.com',
            'password' => bcrypt('123')
        ]);
        $user->assignRole($karyawan);

    }
}
