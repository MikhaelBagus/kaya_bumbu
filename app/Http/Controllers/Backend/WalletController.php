<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Wallet\walletRequest;
use App\Services\Wallet\WalletServiceContract;
use App\Traits\redirectTo;

class WalletController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.wallet.index');
    }

    public function show($id, WalletServiceContract $walletServiceContract)
    {
        return view('backend.wallet.detail', ['wallet' => $walletServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.wallet.create');
    }

    public function store(walletRequest $request, WalletServiceContract $walletServiceContract)
    {
        if (is_object($walletServiceContract->store($request))) {

            return $this->redirectSuccessCreate(route('wallet.index'), 'Wallet');
        } else {

            return $this->redirectFailed(route('wallet.index'), 'Failed To Save Wallet');
        }
    }

    public function edit($id, WalletServiceContract $walletServiceContract)
    {
        $wallet = $walletServiceContract->get($id);
        return view('backend.wallet.update', compact('wallet'));
    }

    public function update(walletRequest $request, $id, WalletServiceContract $walletServiceContract)
    {
        if (is_object($walletServiceContract->update($id, $request))) {

            return $this->redirectSuccessUpdate(route('wallet.index'), 'Wallet');
        } else {

            return $this->redirectFailed(route('wallet.index'), 'Failed To Save Wallet');
        }
    }

    public function destroy($id, WalletServiceContract $walletServiceContract)
    {
        if($walletServiceContract->destroy($id) != ''){
            return $this->redirectSuccessDelete(route('wallet.index'), 'Wallet');
        }
        else{
            return $this->redirectFailed(route('wallet.index'), 'Failed To Delete Wallet');
        }
    }

    public function datatable(Request $request, WalletServiceContract $walletServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                return $walletServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, WalletServiceContract $walletServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $walletServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2Old(Request $request, WalletServiceContract $walletServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $walletServiceContract->select2Old($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
