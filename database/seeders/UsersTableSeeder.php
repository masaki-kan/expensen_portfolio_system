<?php

namespace Database\Seeders;

use App\Rules\TelRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        //
        $user_list = [
            [
                'id' => 1,
                'name' => '管理者',
                'email' => 'k.megashinka@gmail.com',
                'tel' => '090-9999-9999',
                'sex' =>  0,
                'service' => 0,
                'image' =>  null,
                'company' => null,
                'password' => Hash::make('my_secure_password'),
                'md5' => null,
                'flag' => 1,
                'master_flag' => 1,
                'login' => 0,
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30',
            ],
            [
                'id' => 2,
                'name' => 'ユーザー１',
                'email' => 'user1@gmail.com',
                'tel' => '090-9999-9999',
                'sex' =>  0,
                'service' => 0,
                'image' =>  null,
                'company' => null,
                'password' => Hash::make('user1_secure_password'),
                'md5' => null,
                'flag' => 1,
                'master_flag' => 1,
                'login' => 0,
                'created_at' => '2020-08-30',
                'updated_at' => '2020-08-30',
            ]
        ];
        foreach ($user_list as $list) {
            DB::table('users')->insert($list);
        }
    }
}
