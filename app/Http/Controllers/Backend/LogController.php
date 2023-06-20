<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Services\Log\LogServiceContract;
use App\Traits\redirectTo;

class LogController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.log.index');
    }

    public function datatable(Request $request, LogServiceContract $logServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $logServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
