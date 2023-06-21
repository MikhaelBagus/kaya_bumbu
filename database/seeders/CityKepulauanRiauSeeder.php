<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityKepulauanRiauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kabupaten Bintan',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kabupaten Karimun',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kabupaten Kepulauan Anambas',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kabupaten Lingga',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kabupaten Natuna',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kota Batam',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 18,
            'name'        => 'Kota Tanjung Pinang (Tanjungpinang)',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}