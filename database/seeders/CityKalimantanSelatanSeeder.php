<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class CityKalimantanSelatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Balangan',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Banjar',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Barito Kuala',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Hulu Sungai Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Hulu Sungai Tengah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Hulu Sungai Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Citybaru',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Tabalong',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Tanah Bumbu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Tanah Laut',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kabupaten Tapin',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kota Banjarbaru',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 13,
            'name'        => 'Kota Banjarmasin',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}