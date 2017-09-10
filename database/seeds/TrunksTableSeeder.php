<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Trunk;
use App\Models\TrunkStatus;
use App\Models\Store;
use App\Models\Vegetable;

class TrunksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('trunks')->truncate();
        DB::table('trunk_status')->truncate();
        $store = Store::first();
        $vegetable = Vegetable::first();
        if (!$store) {
            $store = factory(Store::class)->create();
        }
        $trunks = factory(Trunk::class, 5)->create([
            'store_id' => $store->id,
        ])->each(function ($trunk) use ($vegetable, $now) {
            factory(TrunkStatus::class, 10)->create([
                'trunk_id' => $trunk->id,
                'vegetable_id' => $vegetable->id,
                'number_grow_day' => 60,
                'planting_day' => $now->toDateTimeString(),
            ]);
        });
    }
}
