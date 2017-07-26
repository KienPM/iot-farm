<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('devices')->truncate();
        DB::table('devices')->insert([
            [
                'id' => 1,
                'name' => 'Cam bien nhiet do',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
