<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityDaerahKhususIbukotaJakartaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 6,
            'name'        => 'Kabupaten Kepulauan Seribu',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 6,
            'name'        => 'Kota Jakarta Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 6,
            'name'        => 'Kota Jakarta Pusat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 6,
            'name'        => 'Kota Jakarta Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 6,
            'name'        => 'Kota Jakarta Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 6,
            'name'        => 'Kota Jakarta Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}