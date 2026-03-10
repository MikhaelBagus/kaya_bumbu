<?php

namespace App\Exports;

use App\Models\Purchase;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $purchases = Purchase::with([
            'wallet',
            'supplier',
            'supplierAccount',
            'purchaseItems.ingredientMaster.ingredient_category.ingredient_group',
            'purchaseItems.expenditureType',
            'purchaseItems.warehouse',
        ])
        ->orderBy('purchase_date', 'desc')
        ->get();

        $rows = [];

        foreach ($purchases as $purchase) {

            $supplierAccountInfo = '';
            if ($purchase->supplierAccount) {
                $supplierAccountInfo =
                    $purchase->supplierAccount->account_number . ' - ' .
                    $purchase->supplierAccount->account_name . ' - ' .
                    $purchase->supplierAccount->bank_name;
            }

            $walletInfo = '';
            if ($purchase->wallet) {
                $walletInfo =
                    $purchase->wallet->account_number . ' - ' .
                    $purchase->wallet->account_name . ' - ' .
                    $purchase->wallet->bank_name;
            }

            foreach ($purchase->purchaseItems as $item) {

                $groupCategoryName = '';
                $categoryName = '';

                if ($item->ingredientMaster && $item->ingredientMaster->ingredient_category) {

                    $categoryName = $item->ingredientMaster
                        ->ingredient_category
                        ->name;

                    if ($item->ingredientMaster
                        ->ingredient_category
                        ->ingredient_group) {

                        $groupCategoryName = $item->ingredientMaster
                            ->ingredient_category
                            ->ingredient_group
                            ->name;
                    }
                }

                $rows[] = [
                    Carbon::parse($purchase->created_at)->format('d M Y'),
                    $item->product_name,
                    $groupCategoryName,
                    $categoryName,
                    Carbon::parse($purchase->purchase_date)->format('d M Y'),
                    $purchase->notes ?? '',
                    $item->po_qty,
                    $item->unit,
                    $item->price,
                    $item->subtotal,
                    $purchase->supplier ? $purchase->supplier->supplier_name : '',
                    $supplierAccountInfo,
                    $walletInfo
                ];
            }
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'TANGGAL INPUT',
            'NAMA ITEM',
            'KATEGORI ITEM',
            'SUB KATEGORI ITEM',
            'TANGGAL PEMBELIAN',
            'KETERANGAN',
            'JUMLAH',
            'UNIT',
            'HARGA SATUAN',
            'TOTAL HARGA',
            'VENDOR',
            'DATA REKENING',
            'PENGELUARAN DARI'
        ];
    }
}