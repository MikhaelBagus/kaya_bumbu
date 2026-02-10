<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\PaymentMethod\paymentMethodRequest;
use App\Services\PaymentMethod\PaymentMethodServiceContract;
use App\Traits\redirectTo;

class PaymentMethodController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.payment_method.index');
    }

    public function show($id, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        return view('backend.payment_method.detail', ['payment_method' => $paymentMethodServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.payment_method.create');
    }

    public function store(paymentMethodRequest $request, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        #Save Payment Method Data
        if (is_object($paymentMethodServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('payment_method.index'), 'Payment Method');
        } else {

            #Bump....
            return $this->redirectFailed(route('payment_method.index'), 'Failed To Save Payment Method');
        }
    }

    public function edit($id, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        $payment_method = $paymentMethodServiceContract->get($id);
        return view('backend.payment_method.update', compact('payment_method'));
    }

    public function update(paymentMethodRequest $request, $id, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        #Save Payment Method Data
        if (is_object($paymentMethodServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('payment_method.index'), 'Payment Method');
        } else {

            #Bump....
            return $this->redirectFailed(route('payment_method.index'), 'Failed To Save Payment Method');
        }
    }

    public function destroy($id, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        if($paymentMethodServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('payment_method.index'), 'Payment Method');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('payment_method.index'), 'Failed To Delete Payment Method');
        }
    }

    public function datatable(Request $request, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $paymentMethodServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, PaymentMethodServiceContract $paymentMethodServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $paymentMethodServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
