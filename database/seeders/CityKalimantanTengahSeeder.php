<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityKalimantanTengahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Barito Selatan',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Barito Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Barito Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Gunung Mas',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Kapuas',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Katingan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Citywaringin Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Citywaringin Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Lamandau',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Murung Raya',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Pulang Pisau',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Sukamara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kabupaten Seruyan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 14,
            'name'        => 'Kota Palangka Raya (Palangkaraya)',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}