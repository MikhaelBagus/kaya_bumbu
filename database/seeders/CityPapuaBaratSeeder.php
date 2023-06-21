<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityPapuaBaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Fakfak',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Kaimana',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Manokwari',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Manokwari Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Maybrat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Pegunungan Arfak',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Raja Ampat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Sorong',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Sorong Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Tambrauw',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Teluk Bintuni',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kabupaten Teluk Wondama',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kota Manokwari',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 25,
            'name'        => 'Kota Sorong',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}