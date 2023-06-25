<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Driver\driverRequest;
use App\Services\Driver\DriverServiceContract;
use App\Traits\redirectTo;

class DriverController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.driver.index');
    }

    public function show($id, DriverServiceContract $driverServiceContract)
    {
        return view('backend.driver.detail', ['driver' => $driverServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.driver.create');
    }

    public function store(driverRequest $request, DriverServiceContract $driverServiceContract)
    {
        #Save Driver Data
        if (is_object($driverServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('driver.index'), 'Driver');
        } else {

            #Bump....
            return $this->redirectFailed(route('driver.index'), 'Failed To Save Driver');
        }
    }

    public function edit($id, DriverServiceContract $driverServiceContract)
    {
        $driver = $driverServiceContract->get($id);
        return view('backend.driver.update', compact('driver'));
    }

    public function update(driverRequest $request, $id, DriverServiceContract $driverServiceContract)
    {
        #Save Driver Data
        if (is_object($driverServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('driver.index'), 'Driver');
        } else {

            #Bump....
            return $this->redirectFailed(route('driver.index'), 'Failed To Save Driver');
        }
    }

    public function destroy($id, DriverServiceContract $driverServiceContract)
    {
        if($driverServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('driver.index'), 'Driver');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('driver.index'), 'Failed To Delete Driver because there is data connected');
        }
    }

    public function datatable(Request $request, DriverServiceContract $driverServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $driverServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, DriverServiceContract $driverServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $driverServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
