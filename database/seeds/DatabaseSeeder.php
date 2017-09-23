<?php

use Illuminate\Database\Seeder;
use App\Models\Vegetable;
use App\Models\Store;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RealSeeder::class);

        // $this->call(DeviceCategoriesTableSeeder::class);
        // $this->call(AdminsTableSeeder::class);
        // $this->call(VegetablesTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(PartnersTableSeeder::class);
        // $this->call(DevicesTableSeeder::class);
        // $this->call(StoresTableSeeder::class);
        // factory(Store::class, 10)->create([
        //         'partner_id' => 1,
        //     ])
        //     ->each(function ($store) {
        //         $vegetables = Vegetable::inRandomOrder()->limit(4)->get()->mapWithKeys(function ($vegetable) {
        //             return [$vegetable->id => ['price' => 10000]];
        //         })->toArray();
        //         $store->vegetables()->attach($vegetables);
        //     });
    }
}
