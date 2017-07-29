<?php

use Illuminate\Database\Seeder;
use App\Models\Vegetable;

class VegetablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vegetables')->truncate();
        factory(Vegetable::class, 10)->create();
    }
}
