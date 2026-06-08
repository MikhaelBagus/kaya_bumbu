<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Services\Purchase\PurchaseServiceContract;
use App\Traits\redirectTo;

class PurchaseController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.purchase.index');
    }

    public function show($id, PurchaseServiceContract $purchaseServiceContract)
    {
        return view('backend.purchase.detail', ['purchase' => $purchaseServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.purchase.create');
    }

    public function store(PurchaseRequest $request, PurchaseServiceContract $purchaseServiceContract)
    {
        #Save Purchase Data
        if (is_object($purchaseServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('purchase.index'), 'Purchase');
        } else {

            #Bump....
            return $this->redirectFailed(route('purchase.index'), 'Failed To Save Purchase');
        }
    }

    public function edit($id, PurchaseServiceContract $purchaseServiceContract)
    {
        $purchase = $purchaseServiceContract->get($id);

        // Add stock information to purchase items from product
        if ($purchase && $purchase->purchaseItems) {
            foreach ($purchase->purchaseItems as $item) {
                if ($item->product) {
                    $item->stock = $item->product->stock ?? 0;
                } else {
                    $item->stock = 0;
                }
            }
        }

        return view('backend.purchase.update', compact('purchase'));
    }

    public function update(PurchaseRequest $request, $id, PurchaseServiceContract $purchaseServiceContract)
    {
        #Save Purchase Data
        if (is_object($purchaseServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('purchase.index'), 'Purchase');
        } else {

            #Bump....
            return $this->redirectFailed(route('purchase.index'), 'Failed To Save Purchase');
        }
    }

    public function destroy($id, PurchaseServiceContract $purchaseServiceContract)
    {
        if($purchaseServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('purchase.index'), 'Purchase');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('purchase.index'), 'Failed To Delete Purchase');
        }
    }

    public function datatable(Request $request, PurchaseServiceContract $purchaseServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $purchaseServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, PurchaseServiceContract $purchaseServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $purchaseServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function download(Request $request, PurchaseServiceContract $purchaseServiceContract)
    {
        if(Sentinel::getUser()){
            return $purchaseServiceContract->download($request);
        }
        else{
            abort('404', 'uups');
        }
    }

    public function approve($id, PurchaseServiceContract $purchaseServiceContract)
    {
        if($purchaseServiceContract->approve($id) != ''){
            #Bump....
            return $this->redirectSuccess(route('purchase.index'), 'Success To Approve Purchase');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('purchase.index'), 'Failed To Approve Purchase');
        }
    }

    public function bulkApprove(Request $request, PurchaseServiceContract $purchaseServiceContract)
    {
        if (!Sentinel::getUser()) {
            abort(404, 'uups');
        }

        $ids = $request->ids ?? [];

        if (!is_array($ids) || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one purchase.'
            ], 422);
        }

        $result = $purchaseServiceContract->bulkApprove($ids);

        return response()->json([
            'success' => true,
            'message' => 'Success to approve selected purchases.',
            'data' => $result
        ]);
    }

    public function paid($id, PurchaseServiceContract $purchaseServiceContract)
    {
        if($purchaseServiceContract->paid($id) != ''){
            #Bump....
            return $this->redirectSuccess(route('purchase.index'), 'Success To Paid Purchase');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('purchase.index'), 'Failed To Paid Purchase');
        }
    }
}
