<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Supplier\SupplierRequest;
use App\Services\Supplier\SupplierServiceContract;
use App\Traits\redirectTo;

class SupplierController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.supplier.index');
    }

    public function show($id, SupplierServiceContract $supplierServiceContract)
    {
        return view('backend.supplier.detail', ['supplier' => $supplierServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.supplier.create');
    }

    public function store(SupplierRequest $request, SupplierServiceContract $supplierServiceContract)
    {
        #Save Supplier Data
        if (is_object($supplierServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('supplier.index'), 'Supplier');
        } else {

            #Bump....
            return $this->redirectFailed(route('supplier.index'), 'Failed To Save Supplier');
        }
    }

    public function edit($id, SupplierServiceContract $supplierServiceContract)
    {
        $supplier = $supplierServiceContract->get($id);
        return view('backend.supplier.update', compact('supplier'));
    }

    public function update(SupplierRequest $request, $id, SupplierServiceContract $supplierServiceContract)
    {
        #Save Supplier Data
        if (is_object($supplierServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('supplier.index'), 'Supplier');
        } else {

            #Bump....
            return $this->redirectFailed(route('supplier.index'), 'Failed To Save Supplier');
        }
    }

    public function destroy($id, SupplierServiceContract $supplierServiceContract)
    {
        if($supplierServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('supplier.index'), 'Supplier');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('supplier.index'), 'Failed To Delete Supplier');
        }
    }

    public function datatable(Request $request, SupplierServiceContract $supplierServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $supplierServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, SupplierServiceContract $supplierServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $supplierServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
