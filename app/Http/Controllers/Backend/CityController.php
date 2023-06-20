<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\City\cityRequest;
use App\Services\City\CityServiceContract;
use App\Traits\redirectTo;

class CityController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.city.index');
    }

    public function show($id, CityServiceContract $cityServiceContract)
    {
        return view('backend.city.detail', ['city' => $cityServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.city.create');
    }

    public function store(cityRequest $request, CityServiceContract $cityServiceContract)
    {
        #Save City Data
        if (is_object($cityServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('city.index'), 'City');
        } else {

            #Bump....
            return $this->redirectFailed(route('city.index'), 'Failed To Save City');
        }
    }

    public function edit($id, CityServiceContract $cityServiceContract)
    {
        $city = $cityServiceContract->get($id);
        return view('backend.city.update', compact('city'));
    }

    public function update(cityRequest $request, $id, CityServiceContract $cityServiceContract)
    {
        #Save City Data
        if (is_object($cityServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('city.index'), 'City');
        } else {

            #Bump....
            return $this->redirectFailed(route('city.index'), 'Failed To Save City');
        }
    }

    public function destroy($id, CityServiceContract $cityServiceContract)
    {
        #Get services for bulk delete
        $cityServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('city.index'), 'City');
    }

    public function datatable(Request $request, CityServiceContract $cityServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $cityServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, CityServiceContract $cityServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $cityServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
