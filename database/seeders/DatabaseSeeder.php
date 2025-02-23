<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // 创建权限
        Permission::create(['name' => 'admin']);

        // 创建角色
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('admin');

        // 创建管理员用户
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $adminUser->assignRole('admin');
    }
}