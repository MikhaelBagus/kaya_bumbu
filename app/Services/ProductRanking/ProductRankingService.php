<?php

namespace App\Services\ProductRanking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\Product;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProductRankingService implements ProductRankingServiceContract
{
    public function get($month, $year)
    {
        $data = TransactionProduct::select(DB::raw('MAX(name) AS product_name'), DB::raw('SUM(qty) AS total_qty'), DB::raw('SUM(qty * price) AS total_price'))
                ->whereHas('transaction', function($q) use($month, $year) {
                    $q->whereMonth('date', $month)->whereYear('date', $year);
                })->groupBy('product_id')->get();

        // dd($data);

        return $data;
    }
}
