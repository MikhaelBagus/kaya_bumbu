<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier_accounts')->insert([
            [
                'supplier_id'    => 1,
                'account_number' => '1234567890',
                'account_name'   => 'PT. Sumber Rezeki',
                'bank_name'      => 'Bank Mandiri',
                'description'    => 'Rekening untuk pembayaran bahan baku',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 2,
                'account_number' => '9876543210',
                'account_name'   => 'CV. Maju Jaya',
                'bank_name'      => 'Bank BCA',
                'description'    => 'Rekening untuk pembayaran packaging',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 3,
                'account_number' => '5554443330',
                'account_name'   => 'UD. Berkah Sejahtera',
                'bank_name'      => 'Bank BRI',
                'description'    => 'Rekening untuk pembayaran bahan pendukung',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 4,
                'account_number' => '7778889990',
                'account_name'   => 'PT. Global Trading',
                'bank_name'      => 'Bank CIMB Niaga',
                'description'    => 'Rekening untuk pembayaran impor',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 5,
                'account_number' => '3332221110',
                'account_name'   => 'Toko Bumbu Nusantara',
                'bank_name'      => 'Bank BNI',
                'description'    => 'Rekening untuk pembayaran rempah lokal',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 6,
                'account_number' => '4445556660',
                'account_name'   => 'Distributor Asia',
                'bank_name'      => 'Bank Permata',
                'description'    => 'Rekening untuk pembayaran distributor',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 7,
                'account_number' => '8889997770',
                'account_name'   => 'Supplier Indonesia',
                'bank_name'      => 'Bank Danamon',
                'description'    => 'Rekening untuk pembayaran lokal',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 8,
                'account_number' => '6667778880',
                'account_name'   => 'Toko Sumber Makmur',
                'bank_name'      => 'Bank BTN',
                'description'    => 'Rekening untuk pembayaran supplies',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 9,
                'account_number' => '2223334440',
                'account_name'   => 'CV. Jaya Abadi',
                'bank_name'      => 'Bank Mega',
                'description'    => 'Rekening untuk pembayaran material',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_id'    => 10,
                'account_number' => '1112223330',
                'account_name'   => 'PT. Indo Global',
                'bank_name'      => 'Bank Bukopin',
                'description'    => 'Rekening untuk pembayaran international',
                'created_by'     => 'root@admin.com',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
