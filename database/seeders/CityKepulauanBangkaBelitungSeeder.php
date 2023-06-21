<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityKepulauanBangkaBelitungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Bangka',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Bangka Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Bangka Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Bangka Tengah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Bangka Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Belitung',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kabupaten Belitung Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 17,
            'name'        => 'Kota Pangkal Pinang (Pangkalpinang)',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}