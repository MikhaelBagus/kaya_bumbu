<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\AboutUs\aboutUsRequest;
use App\Services\AboutUs\AboutUsServiceContract;
use App\Traits\redirectTo;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    use redirectTo;

    public function index()
    {
        $aboutUs = AboutUs::first();
        if($aboutUs){
            $create = false;
        }
        else{
            $create = true;
        }
        return view('backend.about_us.index', compact('create'));
    }

    public function show($id, AboutUsServiceContract $aboutUsServiceContract)
    {
        return view('backend.about_us.detail', ['about_us' => $aboutUsServiceContract->get($id)]);
    }

    public function create()
    {
        $aboutUs = AboutUs::first();
        if($aboutUs){
            return redirect()->route('about_us.index');
        }
        else{
            return view('backend.about_us.create');
        }
    }

    public function store(aboutUsRequest $request, AboutUsServiceContract $aboutUsServiceContract)
    {
        #Save Product Data
        if (is_object($aboutUsServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('about_us.index'), 'About Us');
        } else {

            #Bump....
            return $this->redirectFailed(route('about_us.index'), 'Failed To Save About Us');
        }
    }

    public function edit($id, AboutUsServiceContract $aboutUsServiceContract)
    {
        $about_us = $aboutUsServiceContract->get($id);
        return view('backend.about_us.update', compact('about_us'));
    }

    public function update(aboutUsRequest $request, $id, AboutUsServiceContract $aboutUsServiceContract)
    {
        #Save Product Data
        if (is_object($aboutUsServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('about_us.index'), 'About Us');
        } else {

            #Bump....
            return $this->redirectFailed(route('about_us.index'), 'Failed To Save About Us');
        }
    }

    public function destroy($id, AboutUsServiceContract $aboutUsServiceContract)
    {
        #Get services for bulk delete
        $aboutUsServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('about_us.index'), 'About Us');
    }

    public function bulkDestroy(Request $request, AboutUsServiceContract $aboutUsServiceContract)
    {
        #Get services for bulk delete
        $aboutUsServiceContract->destroyBulk($request->id);

        #Bump....
        return $this->redirectSuccessDelete(route('about_us.index'), 'About Us');
    }

    public function datatable(Request $request, AboutUsServiceContract $aboutUsServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $aboutUsServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, AboutUsServiceContract $aboutUsServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $aboutUsServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
