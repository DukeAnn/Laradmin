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
            'name' => 'admin',
            'email' => 'adk@adki.me',
            'password' => bcrypt('111111')
        ]);
        $user = User::create([
            'name' => 'user',
            'email' => '78580302@qq.com',
            'password' => bcrypt('111111')
        ]);

        $admin->attachRole($role_admin);
        $user->attachRole($role_user);
    }
}
