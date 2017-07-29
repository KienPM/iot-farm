<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Store;
use App\Models\Partner;
use App\Models\Device;
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
        $faker->addProvider(new Faker\Provider\Base($faker));
        $vegetablesInStore = $vegetables->mapWithKeys(function ($vegetable) use ($faker) {
            return [$vegetable->id => ['price' => $faker->numberBetween(5,20)]];
        })->toArray();
        factory(Store::class, 3000)->create()->each(function ($store) use ($vegetablesInStore) {
            $store->devices()->saveMany(factory(Device::class, 100)->make());
            $store->vegetables()->attach($vegetablesInStore);
        });;
    }
}
