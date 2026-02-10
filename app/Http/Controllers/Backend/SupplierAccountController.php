<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\SupplierAccount\SupplierAccountRequest;
use App\Services\SupplierAccount\SupplierAccountServiceContract;
use App\Traits\redirectTo;

class SupplierAccountController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.supplier_account.index');
    }

    public function show($id, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        return view('backend.supplier_account.detail', ['supplier_account' => $supplierAccountServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.supplier_account.create');
    }

    public function store(SupplierAccountRequest $request, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        if (is_object($supplierAccountServiceContract->store($request))) {

            return $this->redirectSuccessCreate(route('supplier_account.index'), 'Supplier Account');
        } else {

            return $this->redirectFailed(route('supplier_account.index'), 'Failed To Save Supplier Account');
        }
    }

    public function edit($id, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        $supplier_account = $supplierAccountServiceContract->get($id);
        return view('backend.supplier_account.update', compact('supplier_account'));
    }

    public function update(SupplierAccountRequest $request, $id, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        if (is_object($supplierAccountServiceContract->update($id, $request))) {

            return $this->redirectSuccessUpdate(route('supplier_account.index'), 'Supplier Account');
        } else {

            return $this->redirectFailed(route('supplier_account.index'), 'Failed To Save Supplier Account');
        }
    }

    public function destroy($id, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        if($supplierAccountServiceContract->destroy($id) != ''){
            return $this->redirectSuccessDelete(route('supplier_account.index'), 'Supplier Account');
        }
        else{
            return $this->redirectFailed(route('supplier_account.index'), 'Failed To Delete Supplier Account');
        }
    }

    public function datatable(Request $request, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                return $supplierAccountServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, SupplierAccountServiceContract $supplierAccountServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $supplierAccountServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
