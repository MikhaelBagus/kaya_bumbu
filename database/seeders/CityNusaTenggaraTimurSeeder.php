<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityNusaTenggaraTimurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Alor',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Belu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Ende',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Flores Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Kupang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Lembata',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Malaka',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Manggarai',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Manggarai Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Manggarai Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Nagekeo',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Ngada',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Rote Ndao',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Sabu Raijua',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Sikka',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Sumba Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Sumba Barat Daya',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Sumba Tengah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Sumba Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Timor Tengah Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kabupaten Timor Tengah Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 23,
            'name'        => 'Kota Kupang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}