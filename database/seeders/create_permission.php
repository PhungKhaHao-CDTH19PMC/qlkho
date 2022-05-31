<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; 

class create_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'Thêm mới người dùng']);
        $permission = Permission::create(['name' => 'Cập nhật người dùng']);
        $permission = Permission::create(['name' => 'Xoá người dùng']);
        $permission = Permission::create(['name' => 'Phân quyền']);
    }
}
