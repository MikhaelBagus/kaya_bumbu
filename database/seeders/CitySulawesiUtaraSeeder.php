<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CitySulawesiUtaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Bolaang Mongondow',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Bolaang Mongondow Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Bolaang Mongondow Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Bolaang Mongondow Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Kepulauan Sangihe',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Kepulauan Siau Tagulandang Biaro (Sitaro)',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Kepulauan Talaud',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Minahasa',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Minahasa Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Minahasa Tenggara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kabupaten Minahasa Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kota Bitung',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kota Citymobagu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kota Manado',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 31,
            'name'        => 'Kota Tomohon',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}