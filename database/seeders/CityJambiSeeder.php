<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityJambiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Batanghari',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Bungo',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Kerinci',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Merangin',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Muaro Jambi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Sarolangun',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Tanjung Jabung Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Tanjung Jabung Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kabupaten Tebo',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kota Jambi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 8,
            'name'        => 'Kota Sungaipenuh',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}