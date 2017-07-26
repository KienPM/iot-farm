<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
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
        $now = Carbon::now();
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'hoanghoiuser',
                'email' => 'hoanghoi1310@gmail.com',
                'phone_number' => '0982708002',
                'password' => bcrypt('12344321'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
        factory(User::class, 40)->create();
    }
}
