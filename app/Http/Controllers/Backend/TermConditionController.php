<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\TermCondition\termConditionRequest;
use App\Services\TermCondition\TermConditionServiceContract;
use App\Traits\redirectTo;
use App\Models\TermCondition;

class TermConditionController extends Controller
{
    use redirectTo;

    public function index()
    {
        $termCondition = TermCondition::first();
        if($termCondition){
            $create = false;
        }
        else{
            $create = true;
        }
        return view('backend.term_condition.index', compact('create'));
    }

    public function show($id, TermConditionServiceContract $termConditionServiceContract)
    {
        return view('backend.term_condition.detail', ['term_condition' => $termConditionServiceContract->get($id)]);
    }

    public function create()
    {
        $termCondition = TermCondition::first();
        if($termCondition){
            return redirect()->route('term_condition.index');
        }
        else{
            return view('backend.term_condition.create');
        }
    }

    public function store(termConditionRequest $request, TermConditionServiceContract $termConditionServiceContract)
    {
        #Save Product Data
        if (is_object($termConditionServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('term_condition.index'), 'Term Condition');
        } else {

            #Bump....
            return $this->redirectFailed(route('term_condition.index'), 'Failed To Save Term Condition');
        }
    }

    public function edit($id, TermConditionServiceContract $termConditionServiceContract)
    {
        $term_condition = $termConditionServiceContract->get($id);
        return view('backend.term_condition.update', compact('term_condition'));
    }

    public function update(termConditionRequest $request, $id, TermConditionServiceContract $termConditionServiceContract)
    {
        #Save Product Data
        if (is_object($termConditionServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('term_condition.index'), 'Term Condition');
        } else {

            #Bump....
            return $this->redirectFailed(route('term_condition.index'), 'Failed To Save Term Condition');
        }
    }

    public function destroy($id, TermConditionServiceContract $termConditionServiceContract)
    {
        #Get services for bulk delete
        $termConditionServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('term_condition.index'), 'Term Condition');
    }

    public function bulkDestroy(Request $request, TermConditionServiceContract $termConditionServiceContract)
    {
        #Get services for bulk delete
        $termConditionServiceContract->destroyBulk($request->id);

        #Bump....
        return $this->redirectSuccessDelete(route('term_condition.index'), 'Term Condition');
    }

    public function datatable(Request $request, TermConditionServiceContract $termConditionServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $termConditionServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, TermConditionServiceContract $termConditionServiceContract)
    {

        if ($request->ajax() === true) {

            return $termConditionServiceContract->select2($request);
        }

        return abort('404', 'uups');
    }
}
