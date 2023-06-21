<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CitySulawesiTengahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Banggai',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Banggai Kepulauan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Banggai Laut',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Buol',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Donggala',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Morowali',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Morowali Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Parigi Moutong',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Poso',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Sigi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Tojo Una-Una',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kabupaten Tolitoli',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 29,
            'name'        => 'Kota Palu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}