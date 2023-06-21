<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityKalimantanBaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Bengkayang',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Kapuas Hulu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Kayong Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Ketapang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Kubu Raya',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Landak',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Melawi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Mempawah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Sambas',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Sanggau',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Sekadau',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kabupaten Sintang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kota Pontianak',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 12,
            'name'        => 'Kota Singkawang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}