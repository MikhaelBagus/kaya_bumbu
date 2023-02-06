<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Disclaimer\disclaimerRequest;
use App\Services\Disclaimer\DisclaimerServiceContract;
use App\Traits\redirectTo;
use App\Models\Disclaimer;

class DisclaimerController extends Controller
{
    use redirectTo;

    public function index()
    {
        $disclaimer = Disclaimer::first();
        if($disclaimer){
            $create = false;
        }
        else{
            $create = true;
        }
        return view('backend.disclaimer.index', compact('create'));
    }

    public function show($id, DisclaimerServiceContract $disclaimerServiceContract)
    {
        return view('backend.disclaimer.detail', ['disclaimer' => $disclaimerServiceContract->get($id)]);
    }

    public function create()
    {
        $disclaimer = Disclaimer::first();
        if($disclaimer){
            return redirect()->route('disclaimer.index');
        }
        else{
            return view('backend.disclaimer.create');
        }
    }

    public function store(disclaimerRequest $request, DisclaimerServiceContract $disclaimerServiceContract)
    {
        #Save Disclaimer Data
        if (is_object($disclaimerServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('disclaimer.index'), 'Disclaimer');
        } else {

            #Bump....
            return $this->redirectFailed(route('disclaimer.index'), 'Failed To Save Disclaimer');
        }
    }

    public function edit($id, DisclaimerServiceContract $disclaimerServiceContract)
    {
        $disclaimer = $disclaimerServiceContract->get($id);
        return view('backend.disclaimer.update', compact('disclaimer'));
    }

    public function update(disclaimerRequest $request, $id, DisclaimerServiceContract $disclaimerServiceContract)
    {
        #Save Disclaimer Data
        if (is_object($disclaimerServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('disclaimer.index'), 'Disclaimer');
        } else {

            #Bump....
            return $this->redirectFailed(route('disclaimer.index'), 'Failed To Save Disclaimer');
        }
    }

    public function destroy($id, DisclaimerServiceContract $disclaimerServiceContract)
    {
        #Get services for bulk delete
        $disclaimerServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('disclaimer.index'), 'Disclaimer');
    }

    public function datatable(Request $request, DisclaimerServiceContract $disclaimerServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $disclaimerServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }
}
