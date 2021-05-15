<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'ゲスト',
            'email' => '',
            'password' => '',
            'icon' => 'icon/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'taro',
            'email' => 'taro@yamada.jp',
            'password' => Crypt::encrypt('yamada'),
            'comment' => '太郎です',
            'icon' => 'icon/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'hanako',
            'email' => 'hanako@flower.jp',
            'password' => Crypt::encrypt('flower'),
            'comment' => '花子です',
            'icon' => 'icon/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'sachiko',
            'email' => 'sachiko@happy.jp',
            'password' => Crypt::encrypt('happy'),
            'comment' => '幸子です',
            'icon' => 'icon/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('users')->insert($param);

    }
}
