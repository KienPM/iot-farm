<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('sensors')->truncate();
        DB::table('sensors')->insert([
            [
                'id' => 1,
                'name' => 'Cam bien nhiet do',
                'password' => bcrypt('12344321'),
                'trunk_id' => 1,
                'category_id' => 1,
                'identify_code' => 'nd001',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
