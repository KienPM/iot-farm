<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(DeviceCategoriesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        // $this->call(VegetablesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PartnersTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        // $this->call(StoresTableSeeder::class);
    }
}
