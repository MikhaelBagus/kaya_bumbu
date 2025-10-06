<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionDownload\transactionDownloadRequest;
use App\Services\TransactionDownload\TransactionDownloadServiceContract;
use App\Traits\redirectTo;
use PDF;

class TransactionDownloadController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.transaction_download.index');
    }

    public function download(transactionDownloadRequest $request, TransactionDownloadServiceContract $transactionDownloadServiceContract)
    {
        #Save Transaction Data
        
        if (is_object($transactionDownloadServiceContract->download($request))) {
            $transaction = $transactionDownloadServiceContract->download($request);
            $pdf = PDF::loadView('backend.transaction_download.pdf', compact('transaction','request'))->setPaper('a4', 'potrait');

            #Bump....
            return $pdf->download('Transaction from '.$request->order_date_from.' to '.$request->order_date_to.'.pdf');
        } else {

            #Bump....
            return $this->redirectFailed(route('transaction_download.index'), 'Failed To Download Transaction');
        }
    }

    public function downloadRecipe(transactionDownloadRequest $request, TransactionDownloadServiceContract $transactionDownloadServiceContract)
    {
        try {
            $data = $transactionDownloadServiceContract->downloadRecipe($request);
            $pdf = PDF::loadView('backend.transaction_download.recipe-pdf', compact('data','request'))->setPaper('a4', 'potrait');

            #Bump....
            return $pdf->download('Recipe Report from '.$request->order_date_from.' to '.$request->order_date_to.'.pdf');
        } catch (\Exception $e) {
            return $this->redirectFailed(route('transaction_download.index'), 'An error occurred: ' . $e->getMessage());
        }
    }
}
