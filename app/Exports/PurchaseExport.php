<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PurchaseExport implements FromCollection, WithHeadings
{
    protected $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $purchases = Purchase::with([
                'wallet',
                'supplier',
                'supplierAccount',
                'paymentMethod',
                'purchaseItems.ingredientMaster.ingredient_category.ingredient_group',
                'purchaseItems.expenditureType',
                'purchaseItems.warehouse',
                'purchaseInstalments',
            ])
            ->withCount([
                'purchaseInstalments as instalment_left_count' => function ($q) {
                    $q->whereNull('paid_date');
                }
            ])
            ->purchaseDate($this->filters['purchase_date_from'] ?? null, $this->filters['purchase_date_to'] ?? null)
            ->totalPurchase($this->filters['total_purchase_from'] ?? null, $this->filters['total_purchase_to'] ?? null)
            ->instalmentCount($this->filters['instalment_count_from'] ?? null, $this->filters['instalment_count_to'] ?? null)
            ->instalmentLeft($this->filters['instalment_left_from'] ?? null, $this->filters['instalment_left_to'] ?? null)
            ->supplier($this->filters['supplier_id'] ?? null)
            ->wallet($this->filters['wallet_id'] ?? null)
            ->supplierAccount($this->filters['supplier_account_id'] ?? null)
            ->paymentMethod($this->filters['payment_method_id'] ?? null)
            ->status($this->filters['status'] ?? null)
            ->orderBy('purchase_date', 'desc')
            ->get();

        $rows = collect();

        foreach ($purchases as $purchase) {
            $supplierAccountInfo = '';
            if ($purchase->supplierAccount) {
                $supplierAccountInfo =
                    ($purchase->supplierAccount->account_number ?? '') . ' - ' .
                    ($purchase->supplierAccount->account_name ?? '') . ' - ' .
                    ($purchase->supplierAccount->bank_name ?? '');
            }

            $walletInfo = '';
            if ($purchase->wallet) {
                $walletInfo =
                    ($purchase->wallet->account_number ?? '') . ' - ' .
                    ($purchase->wallet->account_name ?? '') . ' - ' .
                    ($purchase->wallet->bank_name ?? '');
            }

            if ($purchase->purchaseItems && count($purchase->purchaseItems) > 0) {
                foreach ($purchase->purchaseItems as $item) {
                    $groupCategoryName = '';
                    $categoryName = '';

                    if ($item->ingredientMaster && $item->ingredientMaster->ingredient_category) {
                        $categoryName = $item->ingredientMaster->ingredient_category->name ?? '';

                        if ($item->ingredientMaster->ingredient_category->ingredient_group) {
                            $groupCategoryName = $item->ingredientMaster->ingredient_category->ingredient_group->name ?? '';
                        }
                    }

                    $rows->push([
                        'purchase_code'        => $purchase->code ?? '',
                        'tanggal_input'        => $purchase->created_at ?? '',
                        'nama_item'            => $item->product_name ?? '',
                        'kategori_item'        => $groupCategoryName,
                        'sub_kategori_item'    => $categoryName,
                        'tanggal_pembelian'    => $purchase->purchase_date ?? '',
                        'notes'                => $purchase->notes ?? '',
                        'jumlah'               => $item->po_qty ?? 0,
                        'unit'                 => $item->unit ?? '',
                        'harga_satuan'         => $item->price ?? 0,
                        'total_harga'          => $item->subtotal ?? 0,
                        'supplier'             => optional($purchase->supplier)->supplier_name ?? '',
                        'supplier_account'     => $supplierAccountInfo,
                        'wallet'               => $walletInfo
                    ]);
                }
            } else {
                $rows->push([
                    'purchase_code'        => $purchase->code ?? '',
                    'tanggal_input'        => $purchase->created_at ?? '',
                    'nama_item'            => '',
                    'kategori_item'        => '',
                    'sub_kategori_item'    => '',
                    'tanggal_pembelian'    => $purchase->purchase_date ?? '',
                    'notes'                => $purchase->notes ?? '',
                    'jumlah'               => 0,
                    'unit'                 => '',
                    'harga_satuan'         => 0,
                    'total_harga'          => 0,
                    'supplier'             => optional($purchase->supplier)->supplier_name ?? '',
                    'supplier_account'     => $supplierAccountInfo,
                    'wallet'               => $walletInfo
                ]);
            }
        }

        return new Collection($rows);
    }

    public function headings(): array
    {
        return [
            'KODE PEMBELIAN',
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