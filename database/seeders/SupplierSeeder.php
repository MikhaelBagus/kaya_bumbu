<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier')->insert([
            [
                'supplier_name'        => 'PT. Sumber Rezeki',
                'supplier_description' => 'Supplier bahan baku utama',
                'created_by'         => 'root@admin.com',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'supplier_name'        => 'CV. Maju Jaya',
                'supplier_description' => 'Supplier kemasan dan packaging',
                'created_by'         => 'root@admin.com',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'supplier_name'        => 'UD. Berkah Sejahtera',
                'supplier_description' => 'Supplier bahan pendukung',
                'created_by'         => 'root@admin.com',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'supplier_name'        => 'PT. Global Trading',
                'supplier_description' => 'Supplier impor bahan premium',
                'created_by'         => 'root@admin.com',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'supplier_name'        => 'Toko Bumbu Nusantara',
                'supplier_description' => 'Supplier rempah dan bumbu lokal',
                'created_by'         => 'root@admin.com',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}
