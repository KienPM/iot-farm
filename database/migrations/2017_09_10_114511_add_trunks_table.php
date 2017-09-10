<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrunksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trunks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('code');
            $table->unsignedInteger('store_id');
            $table->boolean('is_actived')->default(true);
            $table->timestamps();
        });
        Schema::create('trunk_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('trunk_id');
            $table->unsignedInteger('vegetable_id');
            $table->unsignedInteger('number_grow_day')->default(1);
            $table->dateTime('planting_day')->nullable();
            $table->boolean('basket_1')->default(false);
            $table->boolean('basket_2')->default(false);
            $table->boolean('basket_3')->default(false);
            $table->boolean('basket_4')->default(false);
            $table->boolean('basket_5')->default(false);
            $table->boolean('basket_6')->default(false);
            $table->boolean('basket_7')->default(false);
            $table->boolean('basket_8')->default(false);
            $table->boolean('basket_9')->default(false);
            $table->boolean('basket_10')->default(false);
            $table->boolean('basket_11')->default(false);
            $table->boolean('basket_12')->default(false);
            $table->boolean('basket_13')->default(false);
            $table->timestamps();
        });
        Schema::table('vegetables', function (Blueprint $table) {
            $table->unsignedInteger('number_grow_day')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vegetables', function (Blueprint $table) {
            $table->dropColumn(['number_grow_day']);
        });
        Schema::dropIfExists('trunks');
        Schema::dropIfExists('trunk_status');
    }
}
