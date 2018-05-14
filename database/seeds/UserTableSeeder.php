<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_user')->delete();
        
        \DB::table('admin_user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'account' => 'admin',
                'realname' => '超级管理员',
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'last_login_ip' => '::1',
                'login_count' => 1,
                'email' => 'tianpian0805@gmail.com',
                'mobile' => '13121126169',
                'remark' => '我是超级管理员',
                'status' => 1,
                'is_delete' => 0,
                'create_at' => '2015-05-18 16:28:07',
                'update_at' => NULL,
                'last_login_time' => '2018-02-02 11:22:26',
            ),
            1 => 
            array (
                'id' => 2,
                'account' => 'demo',
                'realname' => '测试',
                'password' => 'e10adc3949ba59abbe56e057f20f883e',
                'last_login_ip' => '127.0.0.1',
                'login_count' => 5,
                'email' => '',
                'mobile' => '',
                'remark' => '',
                'status' => 1,
                'is_delete' => 0,
                'create_at' => '2015-05-18 16:28:07',
                'update_at' => NULL,
                'last_login_time' => NULL,
            ),
        ));
        
        
    }
}