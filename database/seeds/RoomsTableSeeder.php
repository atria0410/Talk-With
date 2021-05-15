<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 2,
            'title' => 'カードゲーム好きの会',
            'thumbnail' => 'thumbnail/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('rooms')->insert($param);
        
        $param = [
            'user_id' => 3,
            'title' => '映画研究会',
            'thumbnail' => 'thumbnail/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('rooms')->insert($param);

        $param = [
            'user_id' => 4,
            'title' => 'みんなの推しを教えて',
            'thumbnail' => 'thumbnail/default.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];
        DB::table('rooms')->insert($param);
    }
}
