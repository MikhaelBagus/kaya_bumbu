<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityRiauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Bengkalis',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Indragiri Hilir',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Indragiri Hulu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Kampar',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Kepulauan Meranti',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Kuantan Singingi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Pelalawan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Rokan Hilir',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Rokan Hulu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kabupaten Siak',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kota Dumai',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 26,
            'name'        => 'Kota Pekanbaru',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}