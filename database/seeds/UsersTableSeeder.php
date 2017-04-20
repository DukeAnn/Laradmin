<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where(['name' => 'admin'])->first();
        $role_user = Role::where(['name' => 'user'])->first();
        $admin = User::create([
            'id' => 1,
            'name' => '管理员',
            'email' => 'adk@adki.me',
            'password' => bcrypt('111111')
        ]);
        $user = User::create([
            'id' => 2,
            'name' => '用户',
            'email' => '78580302@qq.com',
            'password' => bcrypt('111111')
        ]);

        $admin->attachRole($role_admin);
        $user->attachRole($role_user);
    }
}
