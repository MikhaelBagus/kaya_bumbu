<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Customer\customerFromRequest;
use App\Services\Customer\CustomerServiceContract;
use App\Traits\redirectTo;

class CustomerController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.customer.index');
    }

    public function show($id, CustomerServiceContract $customerServiceContract)
    {
        return view('backend.customer.detail', ['customer' => $customerServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.customer.create');
    }

    public function store(customerFromRequest $request, CustomerServiceContract $customerServiceContract)
    {
        #Save Customer Data
        if (is_object($customerServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('customer.index'), 'Customer');
        } else {

            #Bump....
            return $this->redirectFailed(route('customer.index'), 'Failed To Save Customer');
        }
    }

    public function edit($id, CustomerServiceContract $customerServiceContract)
    {
        $customer = $customerServiceContract->get($id);
        return view('backend.customer.update', compact('customer'));
    }

    public function update(customerFromRequest $request, $id, CustomerServiceContract $customerServiceContract)
    {
        #Save Customer Data
        if (is_object($customerServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('customer.index'), 'Customer');
        } else {

            #Bump....
            return $this->redirectFailed(route('customer.index'), 'Failed To Save Customer');
        }
    }

    public function destroy($id, CustomerServiceContract $customerServiceContract)
    {
        #Get services for bulk delete
        $customerServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('customer.index'), 'Customer');
    }

    public function datatable(Request $request, CustomerServiceContract $customerServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $customerServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, CustomerServiceContract $customerServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $customerServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
