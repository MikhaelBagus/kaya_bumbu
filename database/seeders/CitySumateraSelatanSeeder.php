<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CitySumateraSelatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Banyuasin',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Empat Lawang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Lahat',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Muara Enim',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Musi Banyuasin',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Musi Rawas',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Musi Rawas Utara',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Ogan Ilir',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Ogan Komering Ilir',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Ogan Komering Ulu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Ogan Komering Ulu Selatan',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Ogan Komering Ulu Timur',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kabupaten Penukal Abab Lematang Ilir',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kota Lubuklinggau',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kota Pagar Alam',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kota Palembang',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 33,
            'name'        => 'Kota Prabumulih',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}