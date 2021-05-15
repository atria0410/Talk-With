<?php

use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'room_id' => 1,
            'user_id' => 2,
            'message' => '太郎です。',
            'image' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('chats')->insert($param);

        $param = [
            'room_id' => 1,
            'user_id' => 3,
            'message' => '花子です。',
            'image' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('chats')->insert($param);

        $param = [
            'room_id' => 1,
            'user_id' => 4,
            'message' => '幸子です。',
            'image' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('chats')->insert($param);
    }
}
