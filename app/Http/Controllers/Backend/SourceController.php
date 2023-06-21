<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Source\sourceRequest;
use App\Services\Source\SourceServiceContract;
use App\Traits\redirectTo;

class SourceController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.source.index');
    }

    public function show($id, SourceServiceContract $sourceServiceContract)
    {
        return view('backend.source.detail', ['source' => $sourceServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.source.create');
    }

    public function store(sourceRequest $request, SourceServiceContract $sourceServiceContract)
    {
        #Save Source Data
        if (is_object($sourceServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('source.index'), 'Source');
        } else {

            #Bump....
            return $this->redirectFailed(route('source.index'), 'Failed To Save Source');
        }
    }

    public function edit($id, SourceServiceContract $sourceServiceContract)
    {
        $source = $sourceServiceContract->get($id);
        return view('backend.source.update', compact('source'));
    }

    public function update(sourceRequest $request, $id, SourceServiceContract $sourceServiceContract)
    {
        #Save Source Data
        if (is_object($sourceServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('source.index'), 'Source');
        } else {

            #Bump....
            return $this->redirectFailed(route('source.index'), 'Failed To Save Source');
        }
    }

    public function destroy($id, SourceServiceContract $sourceServiceContract)
    {
        if($sourceServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('source.index'), 'Source');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('source.index'), 'Failed To Delete Source because there is data connected');
        }
    }

    public function datatable(Request $request, SourceServiceContract $sourceServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $sourceServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, SourceServiceContract $sourceServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $sourceServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
