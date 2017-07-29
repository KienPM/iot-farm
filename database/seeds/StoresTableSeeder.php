<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Store;
use App\Models\Partner;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\Vegetable;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $vegetables = Vegetable::all();
        $faker = new Faker\Generator();
        $deviceCategory = DeviceCategory::all();
        $DVCCount = $deviceCategory->count();
        $faker->addProvider(new Faker\Provider\Base($faker));

        $vegetablesInStore = $vegetables->mapWithKeys(function ($vegetable) use ($faker) {
            return [$vegetable->id => ['price' => $faker->numberBetween(5,20)]];
        })->toArray();

        factory(Store::class, 3000)->create()
            ->each(function ($store) use ($vegetablesInStore. $deviceCategory, $faker, $DVCCount) {
                $store->devices()->saveMany(factory(Device::class, 100)->make([
                    'category_id' => $deviceCategory[$faker->numberBetween(0, $DVCCount)]->id,
                ]));
                $store->vegetables()->attach($vegetablesInStore);
            });;
    }
}
