<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(9)->create();

        $user = User::find(1);
        $user->name = '复苏之风';
        $user->email = '576051199@qq.com';
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');
        $user->save();

        $user = User::find(2);
        $user->name = '阿修罗';
        $user->email = '361603760@qq.com';
        // 将 2 号用户指派为『管理员』
        $user->assignRole('Maintainer');
        $user->save();
    }
}
