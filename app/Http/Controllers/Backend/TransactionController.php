<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Transaction\transactionRequest;
use App\Services\Transaction\TransactionServiceContract;
use App\Traits\redirectTo;

class TransactionController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.transaction.index');
    }

    public function show($id, TransactionServiceContract $transactionServiceContract)
    {
        return view('backend.transaction.detail', ['transaction' => $transactionServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.transaction.create');
    }

    public function store(transactionRequest $request, TransactionServiceContract $transactionServiceContract)
    {
        #Save Transaction Data
        if (is_object($transactionServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('transaction.index'), 'Transaction');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction.index'), 'Failed To Save Transaction');
        }
    }

    public function destroy($id, TransactionServiceContract $transactionServiceContract)
    {
        #Get services for bulk delete
        $transactionServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('transaction.index'), 'Transaction');
    }

    public function datatable(Request $request, TransactionServiceContract $transactionServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $transactionServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function editActualOngkirPrice($id, TransactionServiceContract $transactionServiceContract)
    {
        $transaction = $transactionServiceContract->get($id);
        return view('backend.transaction.update_actual_ongkir_price', compact('transaction'));
    }

    public function updateActualOngkirPrice($request, $id, TransactionServiceContract $transactionServiceContract)
    {
        #Save Transaction Data
        if (is_object($transactionServiceContract->updateActualOngkirPrice($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('transaction.index'), 'Transaction');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction.index'), 'Failed To Save Transaction');
        }
    }

    public function updateStartCooking($id, TransactionServiceContract $transactionServiceContract)
    {
        #Save Transaction Data
        if (is_object($transactionServiceContract->updateStartCooking($id))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('transaction.index'), 'Transaction');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction.index'), 'Failed To Save Transaction');
        }
    }

    public function updateEndCooking($id, TransactionServiceContract $transactionServiceContract)
    {
        #Save Transaction Data
        if (is_object($transactionServiceContract->updateEndCooking($id))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('transaction.index'), 'Transaction');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction.index'), 'Failed To Save Transaction');
        }
    }

    public function updateStartDelivery($id, TransactionServiceContract $transactionServiceContract)
    {
        #Save Transaction Data
        if (is_object($transactionServiceContract->updateStartDelivery($id))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('transaction.index'), 'Transaction');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction.index'), 'Failed To Save Transaction');
        }
    }

    public function editEndDelivery($id, TransactionServiceContract $transactionServiceContract)
    {
        $transaction = $transactionServiceContract->get($id);
        return view('backend.transaction.update_end_delivery', compact('transaction'));
    }

    public function updateEndDelivery($request, $id, TransactionServiceContract $transactionServiceContract)
    {
        #Save Transaction Data
        if (is_object($transactionServiceContract->updateEndDelivery($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('transaction.index'), 'Transaction');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction.index'), 'Failed To Save Transaction');
        }
    }

    public function pdf($id, TransactionServiceContract $transactionServiceContract)
    {
        $transaction = $transactionServiceContract->get($id);

        return view('backend.transaction.pdf', compact('transaction'));
    }
}
