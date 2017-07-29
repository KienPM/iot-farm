<?php

use Illuminate\Database\Seeder;
use App\Models\DeviceCategory;

class DeviceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('device_categories')->truncate();
        factory(DeviceCategory::class, 10)->create();
    }
}
