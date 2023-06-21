<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CitySulawesiBaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kabupaten Majene',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kabupaten Mamasa',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kabupaten Mamuju',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kabupaten Mamuju Tengah',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kabupaten Pasangkayu',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kabupaten Polewali Mandar',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('city')->insert([
            'province_id' => 27,
            'name'        => 'Kota Mamuju',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}