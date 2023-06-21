<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityBengkuluSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Bengkulu Selatan',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Bengkulu Tengah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Bengkulu Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Kaur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Kepahiang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Lebong',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Mukomuko',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Rejang Lebong',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kabupaten Seluma',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 4,
            'name'        => 'Kota Bengkulu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}