<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            'bank_name'        => 'Default',
            'account_number'   => '0000000000',
            'account_name'     => 'Default',
            'created_at'       => '2017-05-04 00:00:00'
	    ]);
    }
}