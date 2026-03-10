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
            ->createdAtRange($this->filters['created_at_from'] ?? null, $this->filters['created_at_to'] ?? null)
            ->purchaseDate($this->filters['purchase_date_from'] ?? null, $this->filters['purchase_date_to'] ?? null)
            ->totalPurchase($this->filters['total_purchase_from'] ?? null, $this->filters['total_purchase_to'] ?? null)
            ->instalmentCount($this->filters['instalment_count_from'] ?? null, $this->filters['instalment_count_to'] ?? null)
            ->instalmentLeft($this->filters['instalment_left_from'] ?? null, $this->filters['instalment_left_to'] ?? null)
            ->supplier($this->filters['supplier_id'] ?? null)
            ->wallet($this->filters['wallet_id'] ?? null)
            ->supplierAccount($this->filters['supplier_account_id'] ?? null)
            ->paymentMethod($this->filters['payment_method_id'] ?? null)
            ->status($this->filters['status'] ?? null);

        // tetap bantu seleksi purchase di level query
        if (!empty($this->filters['product_id'])) {
            $purchases->whereHas('purchaseItems', function ($q) {
                $q->where('product_id', $this->filters['product_id']);
            });
        }

        if (($this->filters['po_qty_from'] ?? null) !== null && ($this->filters['po_qty_to'] ?? null) !== null) {
            $purchases->whereHas('purchaseItems', function ($q) {
                $q->whereBetween('po_qty', [$this->filters['po_qty_from'], $this->filters['po_qty_to']]);
            });
        }

        if (($this->filters['price_from'] ?? null) !== null && ($this->filters['price_to'] ?? null) !== null) {
            $purchases->whereHas('purchaseItems', function ($q) {
                $q->whereBetween('price', [$this->filters['price_from'], $this->filters['price_to']]);
            });
        }

        if (($this->filters['item_subtotal_from'] ?? null) !== null && ($this->filters['item_subtotal_to'] ?? null) !== null) {
            $purchases->whereHas('purchaseItems', function ($q) {
                $q->whereBetween('subtotal', [$this->filters['item_subtotal_from'], $this->filters['item_subtotal_to']]);
            });
        }

        if (!empty($this->filters['ingredient_category_id'])) {
            $purchases->whereHas('purchaseItems.ingredientMaster.ingredient_category', function ($q) {
                $q->where('id', $this->filters['ingredient_category_id']);
            });
        }

        if (!empty($this->filters['ingredient_group_id'])) {
            $purchases->whereHas('purchaseItems.ingredientMaster.ingredient_category.ingredient_group', function ($q) {
                $q->where('id', $this->filters['ingredient_group_id']);
            });
        }

        $purchases = $purchases->orderBy('purchase_date', 'desc')->get();

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

            $matchedItems = collect($purchase->purchaseItems)->filter(function ($item) {
                return $this->itemMatchesFilters($item);
            });

            if ($matchedItems->count() > 0) {
                foreach ($matchedItems as $item) {
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
            }
        }

        return new Collection($rows);
    }

    private function itemMatchesFilters($item): bool
    {
        if (!empty($this->filters['product_id'])) {
            if ((int) $item->product_id !== (int) $this->filters['product_id']) {
                return false;
            }
        }

        if (($this->filters['po_qty_from'] ?? null) !== null && ($this->filters['po_qty_to'] ?? null) !== null) {
            if ($item->po_qty < $this->filters['po_qty_from'] || $item->po_qty > $this->filters['po_qty_to']) {
                return false;
            }
        }

        if (($this->filters['price_from'] ?? null) !== null && ($this->filters['price_to'] ?? null) !== null) {
            if ($item->price < $this->filters['price_from'] || $item->price > $this->filters['price_to']) {
                return false;
            }
        }

        if (($this->filters['item_subtotal_from'] ?? null) !== null && ($this->filters['item_subtotal_to'] ?? null) !== null) {
            if ($item->subtotal < $this->filters['item_subtotal_from'] || $item->subtotal > $this->filters['item_subtotal_to']) {
                return false;
            }
        }

        if (!empty($this->filters['ingredient_category_id'])) {
            $itemCategoryId = optional(optional($item->ingredientMaster)->ingredient_category)->id;
            if ((int) $itemCategoryId !== (int) $this->filters['ingredient_category_id']) {
                return false;
            }
        }

        if (!empty($this->filters['ingredient_group_id'])) {
            $itemGroupId = optional(optional(optional($item->ingredientMaster)->ingredient_category)->ingredient_group)->id;
            if ((int) $itemGroupId !== (int) $this->filters['ingredient_group_id']) {
                return false;
            }
        }

        return true;
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