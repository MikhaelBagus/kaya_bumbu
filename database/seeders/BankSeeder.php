<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank')->insert([
            'bank_name'        => 'BCA',
            'account_number'   => '0120431293',
            'account_name'     => 'Daniel Sidarta',
            'created_at'       => '2017-05-04 00:00:00'
	    ]);
    }
}