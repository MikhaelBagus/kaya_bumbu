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
        DB::table('product')->insert([
            'name' 	      => 'Nasi Genggam (Nasi Kuning Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
	    ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Kuning Ayam Woku)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Kuning Ayam Geprek)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Kuning Tempe Kering Manis)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Uduk Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Uduk Ayam Woku)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Uduk Ayam Geprek)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Uduk Tempe Kering Manis)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Putih Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Putih Ayam Woku)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Putih Ayam Geprek)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Putih Tempe Kering Manis)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Liwet Ikan Cakalang)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Liwet Ayam Woku)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Liwet Ayam Geprek)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Genggam (Nasi Liwet Tempe Kering Manis)',
            'price'       => 15000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Ayam Goreng)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Cumi Pedas)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Ikan Cakalang)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Ayam Woku)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Ayam Geprek)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Nasi Bogana)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Value Set (Nasi Liwet)',
            'price'       => 33000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Set (Ayam Goreng)',
            'price'       => 43000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Set (Cumi Pedas)',
            'price'       => 43000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Set (Ikan Cakalang)',
            'price'       => 43000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Set (Ayam Woku)',
            'price'       => 43000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Set (Nasi Bogana)',
            'price'       => 43000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Set (Nasi Liwet)',
            'price'       => 43000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Nusantara Packaging Mika)',
            'price'       => 47000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Nusantara Packaging Keranjang)',
            'price'       => 110000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Manado Packaging Mika)',
            'price'       => 47000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Manado Packaging Keranjang)',
            'price'       => 110000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Bogana Packaging Mika)',
            'price'       => 47000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Bogana Packaging Keranjang)',
            'price'       => 110000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Liwet Packaging Mika)',
            'price'       => 47000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tumpeng Kecil (Tumpeng Liwet Packaging Keranjang)',
            'price'       => 110000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Goreng + Ayam Goreng)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Goreng + Cumi Pedas)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Goreng + Ikan Cakalang)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Goreng + Ayam Woku)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Cumi Pedas + Ayam Goreng)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Cumi Pedas + Cumi Pedas)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Cumi Pedas + Ikan Cakalang)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Cumi Pedas + Ayam Woku)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ikan Cakalang + Ayam Goreng)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ikan Cakalang + Cumi Pedas)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ikan Cakalang + Ikan Cakalang)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ikan Cakalang + Ayam Woku)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Woku + Ayam Goreng)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Woku + Cumi Pedas)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Woku + Ikan Cakalang)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Ayam Woku + Ayam Woku)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Bogana + Ayam Goreng)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Bogana + Cumi Pedas)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Bogana + Ikan Cakalang)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Bogana + Ayam Woku)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Liwet + Ayam Goreng)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Liwet + Cumi Pedas)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Liwet + Ikan Cakalang)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Premium Besek (Nasi Liwet + Ayam Woku)',
            'price'       => 58000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Goreng)',
            'price'       => 250000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Goreng + Tarik Tunai)',
            'price'       => 300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Goreng + Mie Goreng)',
            'price'       => 275000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Goreng + Mie Goreng + Tarik Tunai)',
            'price'       => 325000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ikan Cakalang)',
            'price'       => 250000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ikan Cakalang + Tarik Tunai)',
            'price'       => 300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ikan Cakalang + Mie Goreng)',
            'price'       => 275000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ikan Cakalang + Mie Goreng + Tarik Tunai)',
            'price'       => 325000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Woku)',
            'price'       => 250000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Woku + Tarik Tunai)',
            'price'       => 300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Woku + Mie Goreng)',
            'price'       => 275000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Ayam Woku + Mie Goreng + Tarik Tunai)',
            'price'       => 325000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Bogana)',
            'price'       => 250000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Bogana + Tarik Tunai)',
            'price'       => 300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Bogana + Mie Goreng)',
            'price'       => 275000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Bogana + Mie Goreng + Tarik Tunai)',
            'price'       => 325000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Liwet)',
            'price'       => 250000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Liwet + Tarik Tunai)',
            'price'       => 300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Liwet + Mie Goreng)',
            'price'       => 275000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 1 Tingkat (Nasi Liwet + Mie Goreng + Tarik Tunai)',
            'price'       => 325000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Goreng)',
            'price'       => 400000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Goreng + Tarik Tunai)',
            'price'       => 450000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Goreng + Mie Goreng)',
            'price'       => 440000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Goreng + Mie Goreng + Tarik Tunai)',
            'price'       => 490000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ikan Cakalang)',
            'price'       => 400000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ikan Cakalang + Tarik Tunai)',
            'price'       => 450000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ikan Cakalang + Mie Goreng)',
            'price'       => 440000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ikan Cakalang + Mie Goreng + Tarik Tunai)',
            'price'       => 490000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Woku)',
            'price'       => 400000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Woku + Tarik Tunai)',
            'price'       => 450000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Woku + Mie Goreng)',
            'price'       => 440000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Ayam Woku + Mie Goreng + Tarik Tunai)',
            'price'       => 490000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Bogana)',
            'price'       => 400000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Bogana + Tarik Tunai)',
            'price'       => 450000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Bogana + Mie Goreng)',
            'price'       => 440000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Bogana + Mie Goreng + Tarik Tunai)',
            'price'       => 490000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Liwet)',
            'price'       => 400000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Liwet + Tarik Tunai)',
            'price'       => 450000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Liwet + Mie Goreng)',
            'price'       => 440000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Keranjang 2 Tingkat (Nasi Liwet + Mie Goreng + Tarik Tunai)',
            'price'       => 490000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Nusantara) 5 Pax',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Nusantara) 10 Pax',
            'price'       => 700000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Nusantara) 15 Pax',
            'price'       => 975000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Nusantara) 20 Pax',
            'price'       => 1300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Nusantara) 25 Pax',
            'price'       => 1625000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Nusantara) 30 Pax',
            'price'       => 1950000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Manado) 5 Pax',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Manado) 10 Pax',
            'price'       => 700000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Manado) 15 Pax',
            'price'       => 975000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Manado) 20 Pax',
            'price'       => 1300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Manado) 25 Pax',
            'price'       => 1625000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Manado) 30 Pax',
            'price'       => 1950000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Bogana) 5 Pax',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Bogana) 10 Pax',
            'price'       => 700000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Bogana) 15 Pax',
            'price'       => 975000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Bogana) 20 Pax',
            'price'       => 1300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Bogana) 25 Pax',
            'price'       => 1625000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Bogana) 30 Pax',
            'price'       => 1950000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Liwet) 5 Pax',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Liwet) 10 Pax',
            'price'       => 700000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Liwet) 15 Pax',
            'price'       => 975000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Liwet) 20 Pax',
            'price'       => 1300000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Liwet) 25 Pax',
            'price'       => 1625000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Tumpeng (Tumpeng Liwet) 30 Pax',
            'price'       => 1950000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Meteran (Paket Nusantara) 1 Meter',
            'price'       => 650000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Meteran (Paket Nusantara) 1/2 Meter',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Meteran (Paket Manado) 1 Meter',
            'price'       => 650000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Meteran (Paket Manado) 1/2 Meter',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Meteran (Paket Liwet) 1 Meter',
            'price'       => 650000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Meteran (Paket Liwet) 1/2 Meter',
            'price'       => 350000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Ayam Goreng)',
            'price'       => 520000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Ayam Goreng + Mie Goreng)',
            'price'       => 560000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Ikan Cakalang)',
            'price'       => 520000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Ikan Cakalang + Mie Goreng)',
            'price'       => 560000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Ayam Woku)',
            'price'       => 520000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Ayam Woku + Mie Goreng)',
            'price'       => 560000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Nasi Bogana)',
            'price'       => 520000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Nasi Bogana + Mie Goreng)',
            'price'       => 560000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Nasi Liwet)',
            'price'       => 520000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Treasure Box (Nasi Liwet + Mie Goreng)',
            'price'       => 560000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Box Jajanan Isi 2',
            'price'       => 20000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Box Jajanan Isi 3',
            'price'       => 27000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Box Jajanan Isi 4',
            'price'       => 34000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tampah Jajanan 25 pcs',
            'price'       => 240000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tampah Jajanan 30 pcs',
            'price'       => 275000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Keranjang Jajanan 1 Tingkat',
            'price'       => 220000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Keranjang Jajanan 2 Tingkat',
            'price'       => 415000,
            'unit'        => 'porsi',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Pie Buah',
            'price'       => 9000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Pie Buah',
            'price'       => 9000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nagasari',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Dadar Gulung',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Talam Ubi',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kue Mangkok',
            'price'       => 9000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kue Ku',
            'price'       => 9000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kue Sus',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Lemper Ayam',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kue Cucur',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Risoles',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kue Jungkong',
            'price'       => 10000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Pastel',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kue Lapis',
            'price'       => 8000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Kuning',
            'price'       => 14000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Uduk',
            'price'       => 14000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Nasi Putih',
            'price'       => 9000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Ayam Goreng Paha',
            'price'       => 22000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Ayam Goreng Dada',
            'price'       => 22000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Cumi Pedas',
            'price'       => 55000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Ayam Woku (Fillet)',
            'price'       => 40000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Ayam Geprek (Fillet)',
            'price'       => 20000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Ayam Suwir Kuning',
            'price'       => 40000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Ikan Cakalang Suwir',
            'price'       => 40000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Daging Kaya Bumbu',
            'price'       => 17000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Telur Balado',
            'price'       => 7000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Telur Pindang',
            'price'       => 7000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Perkedel Jagung',
            'price'       => 10000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Perkedel Kentang',
            'price'       => 7000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Kentang Mustofa',
            'price'       => 25000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tempe Kering Manis',
            'price'       => 30000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Tempe Oreg',
            'price'       => 25000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Mie Goreng 4 Pax',
            'price'       => 25000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Mie Goreng 8 Pax',
            'price'       => 40000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Extra Sambal Sedang',
            'price'       => 25000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Extra Sambal Pedas',
            'price'       => 25000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Extra Sambal Roa',
            'price'       => 25000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);

        DB::table('product')->insert([
            'name'        => 'Sambal Roa 250 Gram',
            'price'       => 55000,
            'unit'        => 'pcs',
            'created_at'  => '2017-05-04 00:00:00'
        ]);
    }
}