<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 
class SuperAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $role_Admin = Role::create([
            'name'  => 'Super Admin'
        ]);
        $permission=Permission::all();
        foreach ($permission as $permission_id) {
            $permission_id->assignRole($role_Admin);
        }
    }
}
