<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityDaerahIstimewaYogyakartaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 5,
            'name'        => 'Kabupaten Bantul',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 5,
            'name'        => 'Kabupaten Gunungkidul',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 5,
            'name'        => 'Kabupaten Kulon Progo',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 5,
            'name'        => 'Kabupaten Sleman',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 5,
            'name'        => 'Kota Yogyakarta',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}