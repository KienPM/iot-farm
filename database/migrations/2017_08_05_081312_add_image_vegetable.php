<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageVegetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create images table
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('src');
            $table->timestamps();
        });

        // Create vegetable image table
        Schema::create('vegetable_image', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('image_id')->unsigned();
            $table->integer('vegetable_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('vegetable_image');
    }
}
