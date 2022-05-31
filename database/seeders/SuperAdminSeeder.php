<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username'  => 'superadmin',
            'password'  => Hash::make('123456'),
            'fullname'  => 'Super Admin',
            'email'     => 'superadmin@example.com',
            'role_id'   => 1
        ]);
        
        $user->assignRole('Super Admin');

    }
}
