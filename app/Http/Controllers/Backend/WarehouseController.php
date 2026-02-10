<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Warehouse\warehouseRequest;
use App\Services\Warehouse\WarehouseServiceContract;
use App\Traits\redirectTo;

class WarehouseController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.warehouse.index');
    }

    public function show($id, WarehouseServiceContract $warehouseServiceContract)
    {
        return view('backend.warehouse.detail', ['warehouse' => $warehouseServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.warehouse.create');
    }

    public function store(warehouseRequest $request, WarehouseServiceContract $warehouseServiceContract)
    {
        #Save Warehouse Data
        if (is_object($warehouseServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('warehouse.index'), 'Warehouse');
        } else {

            #Bump....
            return $this->redirectFailed(route('warehouse.index'), 'Failed To Save Warehouse');
        }
    }

    public function edit($id, WarehouseServiceContract $warehouseServiceContract)
    {
        $warehouse = $warehouseServiceContract->get($id);
        return view('backend.warehouse.update', compact('warehouse'));
    }

    public function update(warehouseRequest $request, $id, WarehouseServiceContract $warehouseServiceContract)
    {
        #Save Warehouse Data
        if (is_object($warehouseServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('warehouse.index'), 'Warehouse');
        } else {

            #Bump....
            return $this->redirectFailed(route('warehouse.index'), 'Failed To Save Warehouse');
        }
    }

    public function destroy($id, WarehouseServiceContract $warehouseServiceContract)
    {
        if($warehouseServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('warehouse.index'), 'Warehouse');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('warehouse.index'), 'Failed To Delete Warehouse');
        }
    }

    public function datatable(Request $request, WarehouseServiceContract $warehouseServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $warehouseServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, WarehouseServiceContract $warehouseServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $warehouseServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
