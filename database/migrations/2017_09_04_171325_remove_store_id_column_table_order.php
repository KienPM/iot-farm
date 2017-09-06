<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveStoreIdColumnTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['store_id', 'bank_account_id']);
            $table->string('code')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('store_id')->after('user_id')->unsigned()->nullable();
            $table->dropColumn(['code']);
            $table->integer('bank_account_id')->after('user_id')->unsigned()->nullable();
        });
    }
}
