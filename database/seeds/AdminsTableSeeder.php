<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            [
                'id' => 1,
                'name' => 'hoanghoi-admin',
                'email' => 'hoanghoi1310@gmail.com',
                'phone_number' => '0982708002',
                'password' => bcrypt('12344321'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
