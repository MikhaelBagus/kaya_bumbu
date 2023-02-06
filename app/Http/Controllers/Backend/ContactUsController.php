<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\ContactUs\contactUsRequest;
use App\Services\ContactUs\ContactUsServiceContract;
use App\Traits\redirectTo;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    use redirectTo;

    public function index()
    {
        $contactUs = ContactUs::first();
        if($contactUs){
            $create = false;
        }
        else{
            $create = true;
        }
        return view('backend.contact_us.index', compact('create'));
    }

    public function show($id, ContactUsServiceContract $contactUsServiceContract)
    {
        return view('backend.contact_us.detail', ['contact_us' => $contactUsServiceContract->get($id)]);
    }

    public function create()
    {
        $contactUs = ContactUs::first();
        if($contactUs){
            return redirect()->route('contact_us.index');
        }
        else{
            return view('backend.contact_us.create');
        }
    }

    public function store(contactUsRequest $request, ContactUsServiceContract $contactUsServiceContract)
    {
        #Save Contact Us Data
        if (is_object($contactUsServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('contact_us.index'), 'Contact Us');
        } else {

            #Bump....
            return $this->redirectFailed(route('contact_us.index'), 'Failed To Save Contact Us');
        }
    }

    public function edit($id, ContactUsServiceContract $contactUsServiceContract)
    {
        $contact_us = $contactUsServiceContract->get($id);
        return view('backend.contact_us.update', compact('contact_us'));
    }

    public function update(contactUsRequest $request, $id, ContactUsServiceContract $contactUsServiceContract)
    {
        #Save Contact Us Data
        if (is_object($contactUsServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('contact_us.index'), 'Contact Us');
        } else {

            #Bump....
            return $this->redirectFailed(route('contact_us.index'), 'Failed To Save Contact Us');
        }
    }

    public function destroy($id, ContactUsServiceContract $contactUsServiceContract)
    {
        #Get services for bulk delete
        $contactUsServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('contact_us.index'), 'Contact Us');
    }

    public function bulkDestroy(Request $request, ContactUsServiceContract $contactUsServiceContract)
    {
        #Get services for bulk delete
        $contactUsServiceContract->destroyBulk($request->id);

        #Bump....
        return $this->redirectSuccessDelete(route('contact_us.index'), 'Contact Us');
    }

    public function datatable(Request $request, ContactUsServiceContract $contactUsServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $contactUsServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, ContactUsServiceContract $contactUsServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $contactUsServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
