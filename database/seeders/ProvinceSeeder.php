<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('province')->insert([
            'name' 	  =>  'Aceh',
            'created_at'  =>  '2017-05-04 00:00:00'
	    ]);

        DB::table('province')->insert([
            'name'    =>  'Bali',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Banten',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Bengkulu',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'DI Yogyakarta',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'DKI Jakarta',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Gorontalo',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Jambi',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Jawa Barat',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Jawa Tengah',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Jawa Timur',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kalimantan Barat',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kalimantan Selatan',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kalimantan Tengah',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kalimantan Timur',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kalimantan Utara',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kepulauan Bangka Belitung',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Kepulauan Riau',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Lampung',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Maluku',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Maluku Utara',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Nusa Tenggara Barat (NTB)',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Nusa Tenggara Timur (NTT)',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Papua',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Papua Barat',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Riau',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sulawesi Barat',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sulawesi Selatan',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sulawesi Tengah',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sulawesi Tenggara',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sulawesi Utara',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sumatera Barat',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sumatera Selatan',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);

        DB::table('province')->insert([
            'name'    =>  'Sumatera Utara',
            'created_at'  =>  '2017-05-04 00:00:00'
        ]);
    }
}