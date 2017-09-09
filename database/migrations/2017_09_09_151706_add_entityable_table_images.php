<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityableTableImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->increments('id')->change();
            $table->unsignedInteger('entityable_id');
            $table->string('entityable_type');
        });
        Schema::dropIfExists('vegetable_image');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn(['entityable_id', 'entityable_type']);
        });

        // Create vegetable image table
        Schema::create('vegetable_image', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('image_id')->unsigned();
            $table->integer('vegetable_id')->unsigned();
            $table->timestamps();
        });
    }
}
