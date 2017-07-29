<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Store;
use App\Models\DeviceCategory;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        DB::table('devices')->truncate();
        DB::table('stores')->truncate();
        $storeId = factory(Store::class)->create()->id;
        $categoryId = factory(DeviceCategory::class)->create()->id;
        DB::table('devices')->insert([
            [
                'id' => 1,
                'identify_code' => 'AAAAA0000000001',
                'name' => 'Cam bien nhiet do',
                'password' => bcrypt('12344321'),
                'store_id' => $storeId,
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
