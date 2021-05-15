<?php

use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $param = [
                'user_id' => 2,
                'follow_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ];
            DB::table('follows')->insert($param);

            $param = [
                'user_id' => 2,
                'follow_id' => 4,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ];
            DB::table('follows')->insert($param);

            $param = [
                'user_id' => 4,
                'follow_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ];
            DB::table('follows')->insert($param);
        }
    }
}
