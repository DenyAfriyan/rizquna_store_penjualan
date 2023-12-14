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
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'masterdata']);
        Permission::create(['name' => 'permintaan pengambilan']);
        Permission::create(['name' => 'setujui pengambilan']);
        Permission::create(['name' => 'transaksi limbah']);
        Permission::create(['name' => 'report']);

         //create roles and assign existing permissions
         $penghasil_limbah_role = Role::create(['name' => 'Penghasil Limbah']);
         $penghasil_limbah_role->givePermissionTo('dashboard');
         $penghasil_limbah_role->givePermissionTo('permintaan pengambilan');
         $penghasil_limbah_role->givePermissionTo('report');
 
         $waste_control_role = Role::create(['name' => 'Waste Control']);
         $waste_control_role->givePermissionTo('dashboard');
         $waste_control_role->givePermissionTo('masterdata');
         $waste_control_role->givePermissionTo('setujui pengambilan');
         $waste_control_role->givePermissionTo('transaksi limbah');
         $waste_control_role->givePermissionTo('report');
 
         $superadminRole = Role::create(['name' => 'super-admin']);
         // gets all permissions via Gate::before rule
         // create demo users
        $user = User::factory()->create([
            'name' => 'User Penghasil Limbah',
            'email' => 'user@test.com',
            'password' => bcrypt('123')
        ]);
        $user->assignRole($penghasil_limbah_role);

        $user = User::factory()->create([
            'name' => 'User Waste Control',
            'email' => 'admin@test.com',
            'password' => bcrypt('123')
        ]);
        $user->assignRole($waste_control_role);

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('123')
        ]);
        $user->assignRole($superadminRole);

    }
}
