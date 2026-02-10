<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\ExpenditureType\expenditureTypeRequest;
use App\Services\ExpenditureType\ExpenditureTypeServiceContract;
use App\Traits\redirectTo;

class ExpenditureTypeController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.expenditure_type.index');
    }

    public function show($id, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        return view('backend.expenditure_type.detail', ['expenditure_type' => $expenditureTypeServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.expenditure_type.create');
    }

    public function store(expenditureTypeRequest $request, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        #Save Expenditure Type Data
        if (is_object($expenditureTypeServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('expenditure_type.index'), 'Expenditure Type');
        } else {

            #Bump....
            return $this->redirectFailed(route('expenditure_type.index'), 'Failed To Save Expenditure Type');
        }
    }

    public function edit($id, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        $expenditure_type = $expenditureTypeServiceContract->get($id);
        return view('backend.expenditure_type.update', compact('expenditure_type'));
    }

    public function update(expenditureTypeRequest $request, $id, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        #Save Expenditure Type Data
        if (is_object($expenditureTypeServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('expenditure_type.index'), 'Expenditure Type');
        } else {

            #Bump....
            return $this->redirectFailed(route('expenditure_type.index'), 'Failed To Save Expenditure Type');
        }
    }

    public function destroy($id, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        if($expenditureTypeServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('expenditure_type.index'), 'Expenditure Type');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('expenditure_type.index'), 'Failed To Delete Expenditure Type');
        }
    }

    public function datatable(Request $request, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $expenditureTypeServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, ExpenditureTypeServiceContract $expenditureTypeServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $expenditureTypeServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
