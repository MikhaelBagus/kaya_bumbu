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
use App\Models\Driver;
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

            if($request->customer_city_id == null){
                $customer_city_id = 0;
            }
            else{
                $customer_city_id = $request->customer_city_id;
            }

            if($request->customer_phone == null){
                $customerDb = new Customer();
                $customerDb->name           = $request->customer_name;
                $customerDb->phone          = $request->customer_id;
                $customerDb->city_id        = $customer_city_id;
                $customerDb->address        = $request->customer_address;
                $customerDb->created_by     = Sentinel::getUser()->email;
                $customerDb->save();

                $logDb = new Log();
                $logDb->user_id     = Sentinel::getUser()->id;
                $logDb->action      = 'Create '.$customerDb->name;
                $logDb->menu        = 'Customer';
                $logDb->item_id     = $customerDb->id;
                $logDb->created_by  = Sentinel::getUser()->email;
                $logDb->save();
            }

            $transactionDb = new Transaction();
            if($request->customer_phone == null){
                $transactionDb->customer_id     = $customerDb->id;
            }
            else{
                $transactionDb->customer_id     = $request->customer_id;
            }

            if($request->user_id == null){
                $user_id = Sentinel::getUser()->id;
            }
            else{
                $user_id = $request->user_id;
            }

            $transactionDb->user_id             = $user_id;
            $transactionDb->bank_id             = $request->bank_id;
            $transactionDb->source_id           = $request->source_id;
            $transactionDb->city_id             = $request->city_id;
            $transactionDb->customer_city_id    = $customer_city_id;
            $transactionDb->driver_id           = 0;
            $transactionDb->code                = $transaction_code_new;
            $transactionDb->date                = $request->date;
            $transactionDb->time                = $request->hour.':'.$request->minute;
            $transactionDb->payment_status      = $request->payment_status;
            $transactionDb->discount_price      = $request->discount_price;
            $transactionDb->ongkir_price        = $request->ongkir_price;
            $transactionDb->actual_ongkir_price = $request->actual_ongkir_price;
            $transactionDb->grand_price         = $total_price - $request->discount_price + $request->ongkir_price;
            $transactionDb->address             = $request->address;
            $transactionDb->customer_address    = $request->customer_address;
            $transactionDb->recipient_phone     = $request->recipient_phone;
            $transactionDb->recipient_name      = $request->recipient_name;
            if($request->customer_phone == null){
                $transactionDb->customer_phone  = $request->customer_id;
            }
            else{
                $transactionDb->customer_phone  = $request->customer_phone;
            }
            $transactionDb->customer_name       = $request->customer_name;
            $transactionDb->delivery_option     = $request->delivery_option;
            $transactionDb->delivery_transport  = $request->delivery_transport;
            $transactionDb->delivery_type       = $request->delivery_type;
            $transactionDb->transaction_type    = $request->transaction_type;
            $transactionDb->notes               = $request->notes;
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

    public function update(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $total_price = 0;
            foreach($request->item as $item){
                $total_price = $total_price + ($item['qty'] * $item['price']);
            }

            if($request->customer_city_id == null){
                $customer_city_id = 0;
            }
            else{
                $customer_city_id = $request->customer_city_id;
            }

            if($request->customer_phone == null){
                $customerDb = new Customer();
                $customerDb->name           = $request->customer_name;
                $customerDb->phone          = $request->customer_id;
                $customerDb->city_id        = $customer_city_id;
                $customerDb->address        = $request->customer_address;
                $customerDb->created_by     = Sentinel::getUser()->email;
                $customerDb->save();

                $logDb = new Log();
                $logDb->user_id     = Sentinel::getUser()->id;
                $logDb->action      = 'Create '.$customerDb->name;
                $logDb->menu        = 'Customer';
                $logDb->item_id     = $customerDb->id;
                $logDb->created_by  = Sentinel::getUser()->email;
                $logDb->save();
            }

            $transactionDb = Transaction::find($id);
            if($request->customer_phone == null){
                $transactionDb->customer_id     = $customerDb->id;
            }
            else{
                $transactionDb->customer_id     = $request->customer_id;
            }

            if($request->user_id == null){
                
            }
            else{
                $transactionDb->user_id         = $request->user_id;
            }

            $transactionDb->bank_id             = $request->bank_id;
            $transactionDb->source_id           = $request->source_id;
            $transactionDb->city_id             = $request->city_id;
            $transactionDb->customer_city_id    = $customer_city_id;
            $transactionDb->date                = $request->date;
            $transactionDb->time                = $request->hour.':'.$request->minute;
            $transactionDb->payment_status      = $request->payment_status;
            $transactionDb->discount_price      = $request->discount_price;
            $transactionDb->ongkir_price        = $request->ongkir_price;
            $transactionDb->actual_ongkir_price = $request->actual_ongkir_price;
            $transactionDb->grand_price         = $total_price - $request->discount_price + $request->ongkir_price;
            $transactionDb->address             = $request->address;
            $transactionDb->customer_address    = $request->customer_address;
            $transactionDb->recipient_phone     = $request->recipient_phone;
            $transactionDb->recipient_name      = $request->recipient_name;
            if($request->customer_phone == null){
                $transactionDb->customer_phone  = $request->customer_id;
            }
            else{
                $transactionDb->customer_phone  = $request->customer_phone;
            }
            $transactionDb->customer_name       = $request->customer_name;
            $transactionDb->delivery_option     = $request->delivery_option;
            $transactionDb->delivery_transport  = $request->delivery_transport;
            $transactionDb->delivery_type       = $request->delivery_type;
            $transactionDb->transaction_type    = $request->transaction_type;
            $transactionDb->notes               = $request->notes;
            $transactionDb->updated_by          = Sentinel::getUser()->email;
            $transactionDb->save();

            if(!$transactionDb->transaction_product->isEmpty()){
                foreach($transactionDb->transaction_product as $detail){
                    $detail->forceDelete();
                }
            }

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
                    $transactionProductDb->updated_by     = Sentinel::getUser()->email;
                    $transactionProductDb->save();
                }
            }

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$transactionDb->code;
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

        if(Sentinel::inRole('root')){
            $dataDb = Transaction::select($select)->date($request->order_date_from, $request->order_date_to)->paymentstatus($request->payment_status)->status($request->status)->bank($request->bank_id)->deliveryoption($request->delivery_option)->deliverytransport($request->delivery_transport)->deliverytype($request->delivery_type)->transactiontype($request->transaction_type)->source($request->source_id)->customer($request->customer_id)->user($request->user_id)->province($request->province_id)->city($request->city_id)->driver($request->driver_id)->grandprice($request->grand_price_from, $request->grand_price_to)->with('city','city.province','customer','bank','source','user','driver');
        }
        else{
            $dataDb = Transaction::select($select)->whereNull('suspend_at')->date($request->order_date_from, $request->order_date_to)->paymentstatus($request->payment_status)->status($request->status)->bank($request->bank_id)->deliveryoption($request->delivery_option)->deliverytransport($request->delivery_transport)->deliverytype($request->delivery_type)->transactiontype($request->transaction_type)->source($request->source_id)->customer($request->customer_id)->user($request->user_id)->province($request->province_id)->city($request->city_id)->driver($request->driver_id)->grandprice($request->grand_price_from, $request->grand_price_to)->with('city','city.province','customer','bank','source','user','driver');
        }

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    $updateButton = '';
                    if($dataDb->status == 0){
                        $updateButton = '<a style="font-size: 24px;" href="#" data-message="Mulai Packing '.$dataDb->code.' ?" data-href="' . route('transaction.update_start_cooking', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="Mulai Packing '.$dataDb->code.' ?" data-title-modal="Mulai Packing '.$dataDb->code.' ?" data-toggle="modal" data-target="#delete" title="Mulai Packing '.$dataDb->code.' ?"><span class="label label-success label-sm">Mulai Packing</span></a>';
                    }
                    else if($dataDb->status == 1){
                        $updateButton = '<a style="font-size: 24px;" href="#" data-message="Mulai Pengiriman '.$dataDb->code.' ?" data-href="' . route('transaction.update_start_delivery', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="Mulai Pengiriman '.$dataDb->code.' ?" data-title-modal="Mulai Pengiriman '.$dataDb->code.' ?" data-toggle="modal" data-target="#delete" title="Mulai Pengiriman '.$dataDb->code.' ?"><span class="label label-success label-sm">Mulai Pengiriman</span></a>';
                    }
                    else if($dataDb->status == 2){
                        $updateButton = '<a style="font-size: 24px;" href="'.route('transaction.edit_end_delivery', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-success label-sm">Selesai Pengiriman</span></a>';
                    }

                    $updatePaymentButton = '<a style="font-size: 24px;" href="'.route('transaction.edit_payment_status', [$dataDb->id]).'" id="tooltip" title="Payment Status"><span class="label label-warning label-sm">Payment Status</span></a>';

                    return '<a style="font-size: 24px;" href="' . route('transaction.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('transaction.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('transaction.pdf', [$dataDb->id]).'" id="tooltip" title="PDF"><span class="label label-warning label-sm">PDF</span></a>
                        <a style="font-size: 24px;" href="'.route('transaction.invoice', [$dataDb->id]).'" id="tooltip" title="Invoice"><span class="label label-warning label-sm">Invoice</span></a>
                        <a style="font-size: 24px;" href="'.route('transaction.delivery_pdf', [$dataDb->id]).'" id="tooltip" title="Delivery PDF"><span class="label label-warning label-sm">Delivery PDF</span></a>
                        '.$updateButton.'
                        '.$updatePaymentButton.'
                        <a style="font-size: 24px;" href="'.route('transaction.edit_actual_ongkir_price', [$dataDb->id]).'" id="tooltip" title="Actual Ongkir"><span class="label label-warning label-sm">Actual Ongkir Driver</span></a>
                        <a style="font-size: 24px;" href="#" data-message="Suspend '.$dataDb->code.' ?" data-href="' . route('transaction.update_suspend', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="Suspend '.$dataDb->code.' ?" data-title-modal="Suspend '.$dataDb->code.' ?" data-toggle="modal" data-target="#delete" title="Suspend '.$dataDb->code.' ?"><span class="label label-danger label-sm">Suspend</span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->code]).'" data-href="'.route('transaction.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->addColumn('bank_full', function ($dataDb) {
                return $dataDb->bank->bank_name.' '.$dataDb->bank->account_number.' a/n '.$dataDb->bank->account_name;
            })
            ->addColumn('transaction_detail', function ($dataDb) {
                $transaction_detail = '';
                foreach($dataDb->transaction_product as $detail){
                    if($transaction_detail == ''){
                        if($detail->notes != null){
                            $transaction_detail = '- '.$detail->name.' | '.$detail->qty.' '.$detail->unit.' ('.$detail->notes.')';
                        }
                        else{
                            $transaction_detail = '- '.$detail->name.' | '.$detail->qty.' '.$detail->unit;
                        }
                    }
                    else{
                        if($detail->notes != null){
                            $transaction_detail = $transaction_detail.'<br>- '.$detail->name.' | '.$detail->qty.' '.$detail->unit.' ('.$detail->notes.')';
                        }
                        else{
                            $transaction_detail = $transaction_detail.'<br>- '.$detail->name.' | '.$detail->qty.' '.$detail->unit;
                        }
                    }
                }
                return $transaction_detail;
            })
            ->rawColumns(array('bank_full', 'transaction_detail', 'action'))
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
            if($request->hasFile('file')){
                $file = $request->file;
                $file_path = $file->getPathName();

                $filename = $transactionDb->code.'_transaction_payment_status_'.time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('update_payment_status'), $filename);

                $payment_bukti_transfer_url = 'update_payment_status/'.$filename;
            }
            else{
                $payment_bukti_transfer_url = '';
            }

            if($payment_bukti_transfer_url == ''){
                if($transactionDb->payment_bukti_transfer_url == ''){
                    $transactionDb->payment_bukti_transfer_url = $payment_bukti_transfer_url;
                }
            }
            else{
                $transactionDb->payment_bukti_transfer_url  = $payment_bukti_transfer_url;
            }

            if($request->payment_status != null){
                $transactionDb->payment_status          = $request->payment_status;
            }
            $transactionDb->updated_by                  = Sentinel::getUser()->email;
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
            if($request->driver_id == null || $request->driver_id == 0){
                $driver_id = 0;
            }
            else{
                $driver = Driver::where('id',$request->driver_id)->first();
                if($driver){
                    $driver_id = $driver->id;
                }
                else{
                    $driverDb = new Driver();
                    $driverDb->name          = $request->driver_id;
                    $driverDb->created_by    = Sentinel::getUser()->email;
                    $driverDb->save();

                    $logDb = new Log();
                    $logDb->user_id     = Sentinel::getUser()->id;
                    $logDb->action      = 'Create '.$driverDb->name;
                    $logDb->menu        = 'Driver';
                    $logDb->item_id     = $driverDb->id;
                    $logDb->created_by  = Sentinel::getUser()->email;
                    $logDb->save();

                    $driver_id = $driverDb->id;
                }
            }

            $transactionDb = Transaction::find($id);
            $transactionDb->actual_ongkir_price = $request->actual_ongkir_price;
            $transactionDb->driver_id           = $driver_id;
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
            $logDb->action      = 'Update Start Packing '.$transactionDb->code;
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
            $transactionDb->status             = 2;
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
            $transactionDb = Transaction::find($id);
            if($request->hasFile('file')){
                $file = $request->file;
                $file_path = $file->getPathName();

                $filename = $transactionDb->code.'_transaction_end_delivery_'.time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('update_end_delivery'), $filename);

                $tanda_terima_url = 'update_end_delivery/'.$filename;
            }
            else{
                $tanda_terima_url = '';
            }

            $transactionDb->tanda_terima_url = $tanda_terima_url;
            $transactionDb->status           = 3;
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

    public function updateSuspend(int $id)
    {
        DB::beginTransaction();

        try {
            $transactionDb = Transaction::find($id);
            $transactionDb->suspend_at  = date('y-m-d H:i:s');
            $transactionDb->suspend_by  = Sentinel::getUser()->email;
            $transactionDb->updated_by  = Sentinel::getUser()->email;
            $transactionDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update Suspend '.$transactionDb->code;
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
