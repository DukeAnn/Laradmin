<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'id' => 1,
            'display_name' => '管理员',
            'name' => 'admin',
            'description' => '超级管理员',
        ]);
        $userRole = Role::create([
            'id' => 2,
            'display_name' => '用户',
            'name' => 'user',
            'description' => '普通用户',
        ]);

        /*管理员初始化所有权限*/
        $all_permissions = Permission::all();
        $adminRole->attachPermissions($all_permissions);
        /**
         * 普通用户赋予一般权限
         */
        $loginBackendPer = Permission::where('name', 'system.index')->first();
        $userRole->attachPermission($loginBackendPer);
    }
}
