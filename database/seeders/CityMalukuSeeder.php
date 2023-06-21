<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityMalukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Buru',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Buru Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Kepulauan Aru',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Maluku Barat Daya',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Maluku Tengah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Maluku Tenggara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Maluku Tenggara Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Seram Bagian Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kabupaten Seram Bagian Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kota Ambon',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 20,
            'name'        => 'Kota Tual',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}