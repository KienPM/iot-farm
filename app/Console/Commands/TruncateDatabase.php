<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class TruncateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('users')->truncate();
        DB::table('admins')->truncate();
        DB::table('partners')->truncate();
        DB::table('password_resets')->truncate();
        DB::table('social_users')->truncate();
        DB::table('bank_accounts')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();
        DB::table('vegetables')->truncate();
        DB::table('vegetable_in_store')->truncate();
        DB::table('stores')->truncate();
        DB::table('device_categories')->truncate();
        DB::table('devices')->truncate();
    }
}
