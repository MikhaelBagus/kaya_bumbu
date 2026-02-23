<?php

namespace App\Services\Purchase;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseCost;
use App\Models\PurchaseDiscount;
use App\Models\PurchaseInstalment;
use App\Models\PaymentMethod;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class PurchaseService implements PurchaseServiceContract
{
    public function get(int $id)
    {
        return Purchase::with(['supplier', 'paymentMethod', 'wallet', 'purchaseItems', 'purchaseItems.expenditureType', 'purchaseItems.warehouse', 'purchaseCosts', 'purchaseDiscounts', 'purchaseInstalments'])->find($id);
    }

    public function generatePurchaseCode()
    {
        $lastPurchase   = Purchase::orderBy('id', 'desc')->first();
        $lastNumber     = $lastPurchase ? intval(substr($lastPurchase->code, -5)) : 0;
        $newNumber      = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        return 'PO-' . date('Ymd') . '-' . $newNumber;
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            // dd($request->all());
            // Generate purchase code
            $code = $this->generatePurchaseCode();

            // Create purchase
            $purchase = new Purchase();
            $purchase->code                 = $code;
            $purchase->purchase_date        = $request->purchase_date;
            $purchase->supplier_id          = $request->supplier_id;
            $purchase->supplier_account_id  = $request->supplier_account_id;
            $purchase->payment_method_id    = $request->payment_method_id;

            $status = 'draft';
            $paymentMethod = PaymentMethod::where('id',$request->payment_method_id)->first();
            if($paymentMethod->name == 'Instalment'){
                $purchase->down_payment         = $request->down_payment;
                $purchase->down_payment_date    = $request->down_payment_date;
                $purchase->full_payment_date    = null;
                $purchase->instalment_count     = $request->instalment_count;
            }
            else{
                $purchase->down_payment         = 0;
                $purchase->down_payment_date    = null;
                $purchase->full_payment_date    = $request->full_payment_date;
                $purchase->instalment_count     = 0;

                if($request->full_payment_date != null){
                    $status = 'paid';
                }
            }

            $purchase->wallet_id            = $request->wallet_id;
            $purchase->notes                = $request->notes;
            $purchase->status               = $status;
            $purchase->created_by           = Sentinel::getUser()->email;

            // Calculate totals
            $subtotal = 0;

            // Save purchase items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $itemSubtotal = ($item['price'] * $item['po_qty']);
                    $subtotal += $itemSubtotal;
                }
            }

            // Calculate costs
            $cost = 0;
            if ($request->has('costs') && is_array($request->costs)) {
                foreach ($request->costs as $costItem) {
                    $cost += $costItem['amount'] ?? 0;
                }
            }

            // Calculate discounts
            $discount = 0;
            if ($request->has('discounts') && is_array($request->discounts)) {
                foreach ($request->discounts as $discountItem) {
                    $discount += $discountItem['amount'] ?? 0;
                }
            }

            // Calculate taxes
            $total_purchase = $subtotal + $cost - $discount;

            $purchase->subtotal         = $subtotal;
            $purchase->discount         = $discount;
            $purchase->cost             = $cost;
            $purchase->total_purchase   = $total_purchase;
            $purchase->save();

            // Save purchase items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $purchaseItem = new PurchaseItem();
                    $purchaseItem->purchase_id  = $purchase->id;
                    $purchaseItem->product_id   = $item['product_id'] ?? null;
                    $purchaseItem->product_name = $item['product_name'] ?? '';
                    $purchaseItem->unit         = $item['unit'] ?? '';
                    $purchaseItem->po_qty       = $item['po_qty'] ?? 0;
                    $purchaseItem->last_price   = $item['last_price'] ?? 0;
                    $purchaseItem->price        = $item['price'] ?? 0;
                    $purchaseItem->subtotal     = ($item['price'] * $item['po_qty']);
                    $purchaseItem->warehouse_id         = $item['warehouse_id'];
                    $purchaseItem->expenditure_type_id  = $item['expenditure_type_id'];
                    $purchaseItem->save();

                    $countItem       = $request->items->count();
                    $costPerItem     = $cost / $countItem / $item['po_qty'];
                    $discountPerItem = $discount / $countItem / $item['po_qty'];
                    $lastPrice       = $item['price'] + $costPerItem - $discountPerItem;

                    $purchaseItem->ingredientMaster->price = $lastPrice;
                    $purchaseItem->ingredientMaster->save();
                }
            }

            // Save purchase costs
            if ($request->has('costs') && is_array($request->costs)) {
                foreach ($request->costs as $costItem) {
                    $purchaseCost = new PurchaseCost();
                    $purchaseCost->purchase_id  = $purchase->id;
                    $purchaseCost->cost_name    = $costItem['cost_name'] ?? '';
                    $purchaseCost->amount       = $costItem['amount'] ?? 0;
                    $purchaseCost->notes        = $costItem['notes'] ?? '';
                    $purchaseCost->save();
                }
            }

            // Save purchase discounts
            if ($request->has('discounts') && is_array($request->discounts)) {
                foreach ($request->discounts as $discountItem) {
                    $purchaseDiscount = new PurchaseDiscount();
                    $purchaseDiscount->purchase_id      = $purchase->id;
                    $purchaseDiscount->discount_name    = $discountItem['discount_name'] ?? '';
                    $purchaseDiscount->amount           = $discountItem['amount'] ?? 0;
                    $purchaseDiscount->notes            = $discountItem['notes'] ?? '';
                    $purchaseDiscount->save();
                }
            }

            // Save purchase instalments
            if($paymentMethod->name == 'Instalment'){
                if ($request->has('instalments') && is_array($request->instalments)) {
                    foreach ($request->instalments as $key => $instalmentItem) {
                        $purchaseInstalment = new PurchaseInstalment();
                        $purchaseInstalment->purchase_id        = $purchase->id;
                        $purchaseInstalment->instalment_number  = $key;
                        $purchaseInstalment->due_date           = $instalmentItem['due_date'] ?? null;
                        $purchaseInstalment->amount             = $instalmentItem['amount'] ?? 0;
                        $purchaseInstalment->paid_date          = $instalmentItem['paid_date'] ?? null;
                        $purchaseInstalment->save();

                        if($instalmentItem['paid_date'] != null){
                            $status = 'paid';
                        }
                        else{
                            $status = 'draft';
                        }
                    }
                }
            }

            $purchase->status               = $status;
            $purchase->save();

            // Log
            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create Purchase ' . $purchase->code;
            $logDb->menu        = 'Purchase';
            $logDb->item_id     = $purchase->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $purchase;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function update(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::find($id);

            // Update purchase
            $purchase->purchase_date        = $request->purchase_date;
            $purchase->supplier_id          = $request->supplier_id;
            $purchase->payment_method_id    = $request->payment_method_id;

            $lastStatus = $purchase->status;
            $status = $purchase->status;
            $paymentMethod = PaymentMethod::where('id',$request->payment_method_id)->first();
            if($paymentMethod->name == 'Instalment'){
                $purchase->down_payment         = $request->down_payment;
                $purchase->down_payment_date    = $request->down_payment_date;
                $purchase->full_payment_date    = null;
                $purchase->instalment_count     = $request->instalment_count;
            }
            else{
                $purchase->down_payment         = 0;
                $purchase->down_payment_date    = null;
                $purchase->full_payment_date    = $request->full_payment_date;
                $purchase->instalment_count     = 0;

                if($request->full_payment_date != null){
                    $status = 'paid';
                }
            }

            $purchase->wallet_id            = $request->wallet_id;
            $purchase->notes                = $request->notes;
            $purchase->updated_by           = Sentinel::getUser()->email;

            // Delete existing items, costs, and instalments
            PurchaseItem::where('purchase_id', $id)->delete();
            PurchaseCost::where('purchase_id', $id)->delete();
            PurchaseDiscount::where('purchase_id', $id)->delete();
            PurchaseInstalment::where('purchase_id', $id)->delete();

            // Calculate totals
            $subtotal = 0;

            // Save purchase items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $itemSubtotal = ($item['price'] * $item['po_qty']);
                    $subtotal += $itemSubtotal;
                }
            }

            // Calculate costs
            $cost = 0;
            if ($request->has('costs') && is_array($request->costs)) {
                foreach ($request->costs as $costItem) {
                    $cost += $costItem['amount'] ?? 0;
                }
            }

            // Calculate discounts
            $discount = 0;
            if ($request->has('discounts') && is_array($request->discounts)) {
                foreach ($request->discounts as $discountItem) {
                    $discount += $discountItem['amount'] ?? 0;
                }
            }

            // Calculate taxes
            $total_purchase = $subtotal + $cost - $discount;

            $purchase->subtotal         = $subtotal;
            $purchase->discount         = $discount;
            $purchase->cost             = $cost;
            $purchase->total_purchase   = $total_purchase;
            $purchase->save();

            // Save purchase items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $purchaseItem = new PurchaseItem();
                    $purchaseItem->purchase_id  = $purchase->id;
                    $purchaseItem->product_id   = $item['product_id'] ?? null;
                    $purchaseItem->product_name = $item['product_name'] ?? '';
                    $purchaseItem->unit         = $item['unit'] ?? '';
                    $purchaseItem->po_qty       = $item['po_qty'] ?? 0;
                    $purchaseItem->last_price   = $item['last_price'] ?? 0;
                    $purchaseItem->price        = $item['price'] ?? 0;
                    $purchaseItem->subtotal     = ($item['price'] * $item['po_qty']);
                    $purchaseItem->warehouse_id         = $item['warehouse_id'];
                    $purchaseItem->expenditure_type_id  = $item['expenditure_type_id'];
                    $purchaseItem->save();

                    $countItem       = $request->items->count();
                    $costPerItem     = $cost / $countItem / $item['po_qty'];
                    $discountPerItem = $discount / $countItem / $item['po_qty'];
                    $lastPrice       = $item['price'] + $costPerItem - $discountPerItem;

                    $purchaseItem->ingredientMaster->price = $lastPrice;
                    $purchaseItem->ingredientMaster->save();
                }
            }

            // Save purchase costs
            if ($request->has('costs') && is_array($request->costs)) {
                foreach ($request->costs as $costItem) {
                    $purchaseCost = new PurchaseCost();
                    $purchaseCost->purchase_id  = $purchase->id;
                    $purchaseCost->cost_name    = $costItem['cost_name'] ?? '';
                    $purchaseCost->amount       = $costItem['amount'] ?? 0;
                    $purchaseCost->notes        = $costItem['notes'] ?? '';
                    $purchaseCost->save();
                }
            }

            // Save purchase discounts
            if ($request->has('discounts') && is_array($request->discounts)) {
                foreach ($request->discounts as $discountItem) {
                    $purchaseDiscount = new PurchaseDiscount();
                    $purchaseDiscount->purchase_id      = $purchase->id;
                    $purchaseDiscount->discount_name    = $discountItem['discount_name'] ?? '';
                    $purchaseDiscount->amount           = $discountItem['amount'] ?? 0;
                    $purchaseDiscount->notes            = $discountItem['notes'] ?? '';
                    $purchaseDiscount->save();
                }
            }

            // Save purchase instalments
            if($paymentMethod->name == 'Instalment'){
                if ($request->has('instalments') && is_array($request->instalments)) {
                    foreach ($request->instalments as $key => $instalmentItem) {
                        $purchaseInstalment = new PurchaseInstalment();
                        $purchaseInstalment->purchase_id        = $purchase->id;
                        $purchaseInstalment->instalment_number  = $key;
                        $purchaseInstalment->due_date           = $instalmentItem['due_date'] ?? null;
                        $purchaseInstalment->amount             = $instalmentItem['amount'] ?? 0;
                        $purchaseInstalment->paid_date          = $instalmentItem['paid_date'] ?? null;
                        $purchaseInstalment->save();

                        if($instalmentItem['paid_date'] != null){
                            $status = 'paid';
                        }
                        else{
                            if($lastStatus == 'waiting_for_payment'){
                                $status = 'approved';
                            }
                            else{
                                $status = 'draft';
                            }
                        }
                    }
                }
            }

            $purchase->status               = $status;
            $purchase->save();

            // Log
            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update Purchase ' . $purchase->code;
            $logDb->menu        = 'Purchase';
            $logDb->item_id     = $purchase->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $purchase;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'purchases.*'
        ];

        $query = Purchase::select($select)->with('supplier','supplierAccount','paymentMethod','wallet','purchaseInstalments');

        return DataTables::eloquent($query)
            ->addColumn('checkbox', function ($data) {
                return '';
            })
            ->addColumn('action', function ($data) {
                return view('backend.purchase.action', compact('data'));
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::find($id);
            $purchase->deleted_by = Sentinel::getUser()->email;
            $purchase->save();
            $purchase->delete();

            // Log
            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete Purchase ' . $purchase->code;
            $logDb->menu        = 'Purchase';
            $logDb->item_id     = $purchase->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $purchase;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function select2($request)
    {
        $page = $request->page ?? 1;
        $pageSize = 10;

        $query = Purchase::select('id', 'code', 'purchase_date', 'total_purchase')->orderBy('id', 'desc');

        if ($request->has('search') && $request->search['term'] != '') {
            $query->where('code', 'like', '%' . $request->search['term'] . '%');
        }

        $data = $query->paginate($pageSize, ['*'], 'page', $page);

        $results = [];
        foreach ($data as $item) {
            $results[] = [
                'id' => $item->id,
                'text' => $item->code . ' - ' . $item->purchase_date . ' (Rp ' . number_format($item->total_purchase, 2) . ')',
            ];
        }

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }

    public function download($request)
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

        $fileName = 'purchase' . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($purchases) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, [
                'TANGGAL INPUT',
                'NAMA ITEM',
                'KATEGORI ITEM',
                'SUB KETEGORI ITEM',
                'TANGGAL PEMBELIAN',
                'KETERANGAN',
                'JUMLAH',
                'UNIT',
                'HARGA SATUAN',
                'TOTAL HARGA',
                'VENDOR',
                'DATA REKENING',
                'PENGELUARAN DARI'
            ]);

            foreach($purchases as $purchase){
                $supplierAccountInfo = '';
                if ($purchase->supplierAccount) {
                    $supplierAccount = $purchase->supplierAccount;
                    $supplierAccountInfo = $supplierAccount->account_number . " - " . $supplierAccount->account_name . " - " . $supplierAccount->bank_name ?? '';
                }

                $walletInfo = '';
                if ($purchase->wallet) {
                    $wallet = $purchase->wallet;
                    $walletInfo = $wallet->account_number . " - " . $wallet->account_name . " - " . $wallet->bank_name ?? '';
                }

                // Data rows
                foreach ($purchase->purchaseItems as $item) {
                    // Get ingredient category
                    $groupCategoryName = '';
                    $categoryName = '';
                    if ($item->ingredientMaster && $item->ingredientMaster->ingredient_category) {
                        $categoryName = $item->ingredientMaster->ingredient_category->name;

                        if ($item->ingredientMaster->ingredient_category && $item->ingredientMaster->ingredient_category->ingredient_group) {
                            $groupCategoryName = $item->ingredientMaster->ingredient_category->ingredient_group->name;
                        }
                    }

                    fputcsv($file, [
                        \Carbon\Carbon::parse($purchase->created_at)->format('d M Y'),
                        $item->product_name,
                        $groupCategoryName,
                        $categoryName,
                        \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y'),
                        $purchase->notes ?? '',
                        $item->po_qty,
                        $item->unit,
                        'Rp ' . number_format($item->price, 0, ',', '.'),
                        'Rp ' . number_format($item->subtotal, 0, ',', '.'),
                        $purchase->supplier ? $purchase->supplier->supplier_name : '',
                        $supplierAccountInfo,
                        $walletInfo
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function approve(int $id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::find($id);
            $purchase->approved_by = Sentinel::getUser()->email;
            $purchase->approved_at = date('Y-m-d H:i:s');
            $purchase->status      = 'approved';
            $purchase->save();

            // Log
            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Approve Purchase ' . $purchase->code;
            $logDb->menu        = 'Purchase';
            $logDb->item_id     = $purchase->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $purchase;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function waitingForPayment(int $id)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::find($id);
            $purchase->approved_by = Sentinel::getUser()->email;
            $purchase->approved_at = date('Y-m-d H:i:s');
            $purchase->status      = 'waiting_for_payment';
            $purchase->save();

            // Log
            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Waiting For Payment Purchase ' . $purchase->code;
            $logDb->menu        = 'Purchase';
            $logDb->item_id     = $purchase->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $purchase;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
