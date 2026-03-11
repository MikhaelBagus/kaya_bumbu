<?php

namespace App\Services\TransactionDownload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class TransactionDownloadService implements TransactionDownloadServiceContract
{
    public function download($request)
    {
        $select = [
            'transaction.*',
        ];

        $dataDb = Transaction::select($select)->whereNull('suspend_at')->date($request->order_date_from, $request->order_date_to)->time($request->order_time_from, $request->order_time_to)->paymentstatus($request->payment_status)->status($request->status)->bank($request->bank_id)->deliveryoption($request->delivery_option)->deliverytransport($request->delivery_transport)->deliverytype($request->delivery_type)->transactiontype($request->transaction_type)->source($request->source_id)->customer($request->customer_id)->user($request->user_id)->province($request->province_id)->city($request->city_id)->driver($request->driver_id)->grandprice($request->grand_price_from, $request->grand_price_to)->with('city','city.province','customer','bank','source','user','driver')->orderBy('date','ASC')->orderBy('time','ASC')->get();

        return $dataDb;
    }

    public function downloadRecipe($request)
    {
        $transactions = Transaction::whereNull('suspend_at')
            ->date($request->order_date_from, $request->order_date_to)
            ->time($request->order_time_from, $request->order_time_to)
            ->paymentstatus($request->payment_status)
            ->status($request->status)
            ->bank($request->bank_id)
            ->deliveryoption($request->delivery_option)
            ->deliverytransport($request->delivery_transport)
            ->deliverytype($request->delivery_type)
            ->transactiontype($request->transaction_type)
            ->source($request->source_id)
            ->customer($request->customer_id)
            ->user($request->user_id)
            ->province($request->province_id)
            ->city($request->city_id)
            ->driver($request->driver_id)
            ->grandprice($request->grand_price_from, $request->grand_price_to)
            ->with([
                'city', 
                'city.province', 
                'customer', 
                'bank', 
                'source', 
                'user', 
                'driver',
                'transaction_product',
                'transaction_product.product',
                'transaction_product.product.ingredients'
            ])
            ->orderBy('date', 'ASC')
            ->orderBy('time', 'ASC')
            ->get();

        $productIngredients = [];
        $totalIngredientsMap = [];

        foreach ($transactions as $transaction) {
            $transactionProductIngredients = [];
            foreach ($transaction->transaction_product as $transactionProduct) {
                $product = $transactionProduct->product;
                $productQty = (float) $transactionProduct->qty;

                foreach ($product->ingredients as $ingredient) {
                    $ingredientQtyPerProduct = (float) $ingredient->pivot->qty;
                    $requiredQty = $productQty * $ingredientQtyPerProduct;

                    $productIngredients[] = [
                        'transaction_id' => $transaction->id,
                        'transaction_date' => $transaction->date,
                        'product_name' => $product->name,
                        'product_qty' => $this->formatNumber($productQty),
                        'ingredient_name' => $ingredient->name,
                        'ingredient_unit' => $ingredient->unit,
                        'ingredient_qty_per_product' => $this->formatNumber($ingredientQtyPerProduct),
                        'total_ingredient_qty' => $this->formatNumber($requiredQty)
                    ];

                    $transactionProductIngredients[] = [
                        'transaction_id' => $transaction->id,
                        'transaction_date' => $transaction->date,
                        'product_name' => $product->name,
                        'product_qty' => $this->formatNumber($productQty),
                        'ingredient_name' => $ingredient->name,
                        'ingredient_unit' => $ingredient->unit,
                        'ingredient_qty_per_product' => $this->formatNumber($ingredientQtyPerProduct),
                        'total_ingredient_qty' => $this->formatNumber($requiredQty)
                    ];

                    $transaction['product_ingredients'] = $transactionProductIngredients;

                    $ingredientKey = $ingredient->name . '|' . $ingredient->unit;
                    if (isset($totalIngredientsMap[$ingredientKey])) {
                        $totalIngredientsMap[$ingredientKey]['total_qty'] += $requiredQty;
                    } else {
                        $totalIngredientsMap[$ingredientKey] = [
                            'ingredient_category_group_name' => $ingredient->ingredient_category->ingredient_group->name,
                            'ingredient_category_name' => $ingredient->ingredient_category->name,
                            'ingredient_name' => $ingredient->name,
                            'ingredient_unit' => $ingredient->unit,
                            'total_qty' => $requiredQty
                        ];
                    }
                }
            }
        }
        
        $totalIngredients = collect(array_values($totalIngredientsMap))
        ->map(function ($ingredient) {
            $ingredient['total_qty'] = $this->formatNumber($ingredient['total_qty']);
            return $ingredient;
        })
        ->sortBy('ingredient_name')
        ->values();

        return [
            'transactions' => $transactions,
            'product_ingredients' => collect($productIngredients),
            'total_ingredients' => $totalIngredients
        ];
    }

    private function formatNumber($number, $maxDecimals = 2)
    {
        $hasDecimals = ($number - floor($number)) > 0;
        
        if (!$hasDecimals) {
            return number_format($number, 0, ',', '.');
        } else {
            return number_format($number, $maxDecimals, ',', '.');
        }
    }
}
