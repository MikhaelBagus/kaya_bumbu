<?php

namespace App\Services\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Log;
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

            if($request->customer_phone == null){
                $customerDb = new Customer();
                $customerDb->name           = $request->customer_name;
                $customerDb->phone          = $request->customer_id;
                $customerDb->city_id        = $request->city_id;
                $customerDb->address        = $request->address;
                $customerDb->created_by     = Sentinel::getUser()->email;
                $customerDb->save();
            }

            $transactionDb = new Transaction();
            if($request->customer_phone == null){
                $transactionDb->customer_id     = $customerDb->id;
            }
            else{
                $transactionDb->customer_id     = $request->customer_id;
            }
            $transactionDb->bank_id             = $request->bank_id;
            $transactionDb->source_id           = $request->source_id;
            $transactionDb->city_id             = $request->city_id;
            $transactionDb->code                = $transaction_code_new;
            $transactionDb->date                = $request->date;
            $transactionDb->payment_status      = $request->payment_status;
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
                    $transactionProductDb->name           = $item['name'];
                    $transactionProductDb->qty            = $item['qty'];
                    $transactionProductDb->price          = $item['price'];
                    $transactionProductDb->unit           = $item['unit'];
                    $transactionProductDb->notes          = $item['notes'];
                    $transactionProductDb->created_by     = Sentinel::getUser()->email;
                    $transactionProductDb->save();
                }
            }

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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

        $dataDb = Transaction::select($select)->date($request->order_date_from, $request->order_date_to)->paymentstatus($request->payment_status)->status($request->status)->bank($request->bank_id)->source($request->source_id)->customer($request->customer_id)->with('city','city.province','customer','bank','source');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    $updateButton = '';
                    if($dataDb->status == 0){
                        $updateButton = '<a href="#" data-message="Start Cooking '.$dataDb->code.' ?" data-href="' . route('transaction.update_start_cooking', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="Start Cooking '.$dataDb->code.' ?" data-title-modal="Start Cooking '.$dataDb->code.' ?" data-toggle="modal" data-target="#delete" title="Start Cooking '.$dataDb->code.' ?"><span class="label label-success label-sm">Start Cooking</span></a>';
                    }
                    else if($dataDb->status == 1){
                        $updateButton = '<a href="#" data-message="End Cooking '.$dataDb->code.' ?" data-href="' . route('transaction.update_end_cooking', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="End Cooking '.$dataDb->code.' ?" data-title-modal="End Cooking '.$dataDb->code.' ?" data-toggle="modal" data-target="#delete" title="End Cooking '.$dataDb->code.' ?"><span class="label label-success label-sm">End Cooking</span></a>';
                    }
                    else if($dataDb->status == 2){
                        $updateButton = '<a href="#" data-message="Start Delivery '.$dataDb->code.' ?" data-href="' . route('transaction.update_start_delivery', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="Start Delivery '.$dataDb->code.' ?" data-title-modal="Start Delivery '.$dataDb->code.' ?" data-toggle="modal" data-target="#delete" title="Start Delivery '.$dataDb->code.' ?"><span class="label label-success label-sm">Start Delivery</span></a>';
                    }
                    else if($dataDb->status == 3){
                        $updateButton = '<a href="'.route('transaction.edit_end_delivery', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-success label-sm">End Delivery</span></a>';
                    }

                    $updatePaymentButton = '';
                    if($dataDb->payment_status == 0){
                        $updatePaymentButton = '<a href="'.route('transaction.edit_payment_status', [$dataDb->id]).'" id="tooltip" title="Payment Status"><span class="label label-warning label-sm">Payment Status</span></a>';
                    }

                    return '<a href="' . route('transaction.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('transaction.pdf', [$dataDb->id]).'" id="tooltip" title="PDF"><span class="label label-warning label-sm">PDF</span></a>
                        '.$updateButton.'
                        '.$updatePaymentButton.'
                        <a href="'.route('transaction.edit_actual_ongkir_price', [$dataDb->id]).'" id="tooltip" title="Actual Ongkir"><span class="label label-warning label-sm">Actual Ongkir</span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->code]).'" data-href="'.route('transaction.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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

        $logDb = new Log();
        $logDb->user_id     = Sentinel::getUser()->id;
        $logDb->action      = 'Delete '.$transactionDb->code;
        $logDb->menu        = 'Transaction';
        $logDb->item_id     = $transactionDb->id;
        $logDb->created_by  = Sentinel::getUser()->email;
        $logDb->save();

        return Transaction::where('id', $id)->delete();
    }

    public function updatePaymentStatus(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->payment_status = $request->payment_status;
            $transactionDb->updated_by     = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update Payment Status '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function updateActualOngkirPrice(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->actual_ongkir_price = $request->actual_ongkir_price;
            $transactionDb->updated_by          = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update Actual Ongkir Price '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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
            $transactionDb->start_cooking_at = date('y-m-d H:i:s');
            $transactionDb->start_cooking_by = Sentinel::getUser()->email;
            $transactionDb->updated_by       = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update Start Cooking '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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
            $transactionDb->end_cooking_at  = date('y-m-d H:i:s');
            $transactionDb->end_cooking_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by      = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update End Cooking '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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
            $transactionDb->start_delivery_at  = date('y-m-d H:i:s');
            $transactionDb->start_delivery_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by         = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update Start Delivery '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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
            if($request->hasFile('file')){
                $file = $request->file;
                $file_path = $file->getPathName();

                $filename = time().'_update_end_delivery.'.$file->getClientOriginalExtension();
                $file->move(public_path('update_end_delivery'), $filename);

                $tanda_terima_url = 'update_end_delivery/'.$filename;
            }
            else{
                $tanda_terima_url = '';
            }

            $transactionDb = Transaction::find($id);
            $transactionDb->tanda_terima_url = $tanda_terima_url;
            $transactionDb->status           = 4;
            $transactionDb->end_delivery_at  = date('y-m-d H:i:s');
            $transactionDb->end_delivery_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by       = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update End Delivery '.$transactionDb->code;
            $logDb->menu        = 'Transaction';
            $logDb->item_id     = $transactionDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $transactionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
