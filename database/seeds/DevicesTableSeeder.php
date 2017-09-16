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
        DB::table('device_categories')->truncate();
        $storeId = factory(Store::class)->create([
            'partner_id' => 1,
        ])->id;

        DB::table('device_categories')->insert([
            [
                'id' => 1,
                'name' => 'Cảm biến',
                'symbol' => 'A',
                'description' => 'Thiết bị đo điều kiện môi trường xung quanh',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
        ]);

        DB::table('devices')->insert([
            [
                'id' => 1,
                'identify_code' => 'AAAAA0000000001',
                'name' => 'Cảm biến nhiệt độ nước',
                'password' => bcrypt('12344321'),
                'store_id' => $storeId,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'identify_code' => 'AAAAA0000000002',
                'name' => 'Cảm biến nhiệt độ không khí',
                'password' => bcrypt('12344321'),
                'store_id' => $storeId,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'identify_code' => 'AAAAA0000000003',
                'name' => 'Cảm biến PH',
                'password' => bcrypt('12344321'),
                'store_id' => $storeId,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
