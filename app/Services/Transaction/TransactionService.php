<?php

namespace App\Services\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class TransactionService implements TransactionServiceContract
{
    public function get(int $id)
    {
        return Transaction::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $date = date('ymd');
            $transaction = Transaction::orderBy('id','desc')->first();

            if($transaction == null){
                $id = 1;
            }
            else{
                $code_last = substr($transaction->code,-4);
                $code_date = substr($transaction->code, 0 ,6);
                if($code_date == $date){
                    $id = (int)$code_last +1;

                }
                else{
                    $id = 1;
                }
            }
            $transaction_code_new = $date.sprintf("%04d", $id);

            $total_price = 0;
            foreach($request->item as $item){
                $total_price = $total_price + ($item['qty'] * $item['price']);
            }

            $transactionDb = new Transaction();
            $transactionDb->customer_id         = $request->customer_id;
            $transactionDb->bank_id             = $request->bank_id;
            $transactionDb->source_id           = $request->source_id;
            $transactionDb->city_id             = $request->city_id;
            $transactionDb->code                = $transaction_code_new;
            $transactionDb->date                = $request->date;
            $transactionDb->discount_price      = $request->discount_price;
            $transactionDb->ongkir_price        = $request->ongkir_price;
            $transactionDb->actual_ongkir_price = $request->ongkir_price;
            $transactionDb->grand_price         = $total_price - $request->discount_price + $request->ongkir_price;
            $transactionDb->address             = $request->address;
            $transactionDb->status              = 0;
            $transactionDb->created_by          = Sentinel::getUser()->email;
            $transactionDb->save();

            foreach($request->item as $item){
                $productDb = Product::where('id',$item['product_id'])->first();
                if($productDb){
                    $transactionProductDb = new TransactionProduct();
                    $transactionProductDb->product_id     = $item['product_id'];
                    $transactionProductDb->transaction_id = $transactionDb->id;
                    $transactionProductDb->qty            = $item['qty'];
                    $transactionProductDb->price          = $item['price'];
                    $transactionProductDb->created_by     = Sentinel::getUser()->email;
                    $transactionProductDb->save();
                }
            }

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'transaction.*',
        ];

        $dataDb = Transaction::select($select)->date($request->order_date_from, $request->order_date_to)->with('city','city.province','customer','bank','source');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('transaction.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('transaction.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->make(true);
    }

    public function destroy(int $id)
    {
        $transactionDb = Transaction::where('id', $id)->first();
        $transactionDb->deleted_by = Sentinel::getUser()->email;
        $transactionDb->save();

        foreach($transactionDb->transaction_product as $transactionProductDb){
            $transactionProductDb->deleted_by = Sentinel::getUser()->email;
            $transactionProductDb->save();

            $transactionProductDb->delete();
        }

        return Transaction::where('id', $id)->delete();
    }

    public function updateActualOngkirPrice(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->actual_ongkir_price = $request->actual_ongkir_price;
            $transactionDb->updated_by          = Sentinel::getUser()->email;
            $transactionDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function updateStartCooking(int $id)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->status           = 1;
            $transactionDb->start_cooking_at = date('yyyy-mm-dd H:i:s');
            $transactionDb->start_cooking_by = Sentinel::getUser()->email;
            $transactionDb->updated_by       = Sentinel::getUser()->email;
            $transactionDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function updateEndCooking(int $id)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->status          = 2;
            $transactionDb->end_cooking_at  = date('yyyy-mm-dd H:i:s');
            $transactionDb->end_cooking_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by      = Sentinel::getUser()->email;
            $transactionDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function updateStartDelivery(int $id)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->status             = 3;
            $transactionDb->start_delivery_at  = date('yyyy-mm-dd H:i:s');
            $transactionDb->start_delivery_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by         = Sentinel::getUser()->email;
            $transactionDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function updateEndDelivery(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->status           = 4;
            $transactionDb->end_delivery_at  = date('yyyy-mm-dd H:i:s');
            $transactionDb->end_delivery_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by       = Sentinel::getUser()->email;
            $transactionDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
