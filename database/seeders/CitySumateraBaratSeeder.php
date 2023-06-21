<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CitySumateraBaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Agam',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Dharmasraya',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Kepulauan Mentawai',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Lima Puluh City',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Padang Pariaman',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Pasaman',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Pasaman Barat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Pesisir Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Sijunjung',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Solok',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Solok Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kabupaten Tanah Datar',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Bukittinggi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Padang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Padangpanjang (Padang Panjang)',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Pariaman',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Payakumbuh',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Sawahlunto',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 32,
            'name'        => 'Kota Solok',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}