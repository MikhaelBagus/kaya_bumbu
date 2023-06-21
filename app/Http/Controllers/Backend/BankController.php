<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Bank\bankRequest;
use App\Services\Bank\BankServiceContract;
use App\Traits\redirectTo;

class BankController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.bank.index');
    }

    public function show($id, BankServiceContract $bankServiceContract)
    {
        return view('backend.bank.detail', ['bank' => $bankServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.bank.create');
    }

    public function store(bankRequest $request, BankServiceContract $bankServiceContract)
    {
        #Save Bank Data
        if (is_object($bankServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('bank.index'), 'Bank');
        } else {

            #Bump....
            return $this->redirectFailed(route('bank.index'), 'Failed To Save Bank');
        }
    }

    public function edit($id, BankServiceContract $bankServiceContract)
    {
        $bank = $bankServiceContract->get($id);
        return view('backend.bank.update', compact('bank'));
    }

    public function update(bankRequest $request, $id, BankServiceContract $bankServiceContract)
    {
        #Save Bank Data
        if (is_object($bankServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('bank.index'), 'Bank');
        } else {

            #Bump....
            return $this->redirectFailed(route('bank.index'), 'Failed To Save Bank');
        }
    }

    public function destroy($id, BankServiceContract $bankServiceContract)
    {
        if($bankServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('bank.index'), 'Bank');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('bank.index'), 'Failed To Delete Bank because there is data connected');
        }
    }

    public function datatable(Request $request, BankServiceContract $bankServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $bankServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, BankServiceContract $bankServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $bankServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
