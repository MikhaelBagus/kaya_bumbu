<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Province\provinceRequest;
use App\Services\Province\ProvinceServiceContract;
use App\Traits\redirectTo;

class ProvinceController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.province.index');
    }

    public function show($id, ProvinceServiceContract $provinceServiceContract)
    {
        return view('backend.province.detail', ['province' => $provinceServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.province.create');
    }

    public function store(provinceRequest $request, ProvinceServiceContract $provinceServiceContract)
    {
        #Save Province Data
        if (is_object($provinceServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('province.index'), 'Province');
        } else {

            #Bump....
            return $this->redirectFailed(route('province.index'), 'Failed To Save Province');
        }
    }

    public function edit($id, ProvinceServiceContract $provinceServiceContract)
    {
        $province = $provinceServiceContract->get($id);
        return view('backend.province.update', compact('province'));
    }

    public function update(provinceRequest $request, $id, ProvinceServiceContract $provinceServiceContract)
    {
        #Save Province Data
        if (is_object($provinceServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('province.index'), 'Province');
        } else {

            #Bump....
            return $this->redirectFailed(route('province.index'), 'Failed To Save Province');
        }
    }

    public function destroy($id, ProvinceServiceContract $provinceServiceContract)
    {
        if($provinceServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('province.index'), 'Province');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('province.index'), 'Failed To Delete Province because there is data connected');
        }
    }

    public function datatable(Request $request, ProvinceServiceContract $provinceServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $provinceServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, ProvinceServiceContract $provinceServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $provinceServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
