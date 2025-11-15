<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->insert([
            'name'        => 'Default'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name' 	      => 'Nasi Genggam (Nasi Kuning Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Kuning Ayam Woku)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Kuning Ayam Geprek)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Kuning Tempe Kering Manis)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Uduk Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Uduk Ayam Woku)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Uduk Ayam Geprek)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Uduk Tempe Kering Manis)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'product_category_id' => 1,
            'name'        => 'Nasi Genggam (Nasi Putih Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}