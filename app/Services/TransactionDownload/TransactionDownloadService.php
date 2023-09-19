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

        $dataDb = Transaction::select($select)->whereNull('suspend_at')->date($request->order_date_from, $request->order_date_to)->paymentstatus($request->payment_status)->status($request->status)->bank($request->bank_id)->deliveryoption($request->delivery_option)->deliverytransport($request->delivery_transport)->deliverytype($request->delivery_type)->transactiontype($request->transaction_type)->source($request->source_id)->customer($request->customer_id)->user($request->user_id)->province($request->province_id)->city($request->city_id)->driver($request->driver_id)->grandprice($request->grand_price_from, $request->grand_price_to)->with('city','city.province','customer','bank','source','user','driver')->orderBy('date','ASC')->orderBy('time','ASC')->get();

        return $dataDb;
    }
}
