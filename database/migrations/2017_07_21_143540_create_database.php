<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password');
            $table->boolean('is_actived')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password');
            $table->boolean('is_actived')->default(true);
            $table->boolean('is_super')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password');
            $table->boolean('is_actived')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('social_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('provider');
            $table->string('provider_user_token');
            $table->timestamps();
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('account');
            $table->boolean('is_actived')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('bank_account_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('total_price')->unsigned();
            $table->tinyInteger('status')->unsigned();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('vegetable_in_store_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->timestamps();
        });

        Schema::create('vegetables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->boolean('is_actived')->default(true);
            $table->timestamps();
        });

        Schema::create('vegetables_in_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vegetable_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('price')->unsigned();
            $table->timestamps();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partner_id')->unsigned();
            $table->string('address');
            $table->text('info');
            $table->boolean('is_actived')->default(true);
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->string('password');
            $table->boolean('is_actived')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('device_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->text('description');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('social_users');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('vegetables');
        Schema::dropIfExists('vegetables_in_stores');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('trunks');
        Schema::dropIfExists('devices');
        Schema::dropIfExists('device_categories');
    }
}
