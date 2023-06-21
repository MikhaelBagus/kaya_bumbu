<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('source')->insert([
            'name' 	      => 'Default',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('source')->insert([
            'name'        => 'Whatsapp',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Telegram',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Instagram Post',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Instagram Story',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Instagram Live',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'TikTok Post',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'TikTok Live',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Twitter Post',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Twitter Live',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'YouTube Post',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'YouTube Short',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'YouTube Live',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('source')->insert([
            'name'        => 'Google',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}