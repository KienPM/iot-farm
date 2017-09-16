<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('partners')->truncate();
        DB::table('partners')->insert([
            [
                'id' => 1,
                'name' => 'hoanghoi-partner',
                'email' => 'hoanghoi1310@gmail.com',
                'phone_number' => '0982708002',
                'password' => bcrypt('12344321'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
