<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Faq\faqRequest;
use App\Services\Faq\FaqServiceContract;
use App\Traits\redirectTo;

class FaqController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.faq.index');
    }

    public function show($id, FaqServiceContract $faqServiceContract)
    {
        return view('backend.faq.detail', ['faq' => $faqServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.faq.create');
    }

    public function store(faqRequest $request, FaqServiceContract $faqServiceContract)
    {
        #Save Product Data
        if (is_object($faqServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('faq.index'), 'Faq');
        } else {

            #Bump....
            return $this->redirectFailed(route('faq.index'), 'Failed To Save Faq');
        }
    }

    public function edit($id, FaqServiceContract $faqServiceContract)
    {
        $faq = $faqServiceContract->get($id);
        return view('backend.faq.update', compact('faq'));
    }

    public function update(faqRequest $request, $id, FaqServiceContract $faqServiceContract)
    {
        #Save Product Data
        if (is_object($faqServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('faq.index'), 'Faq');
        } else {

            #Bump....
            return $this->redirectFailed(route('faq.index'), 'Failed To Save Faq');
        }
    }

    public function destroy($id, FaqServiceContract $faqServiceContract)
    {
        #Get services for bulk delete
        $faqServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('faq.index'), 'Faq');
    }

    public function bulkDestroy(Request $request, FaqServiceContract $faqServiceContract)
    {
        #Get services for bulk delete
        $faqServiceContract->destroyBulk($request->id);

        #Bump....
        return $this->redirectSuccessDelete(route('faq.index'), 'Faq');
    }

    public function datatable(Request $request, FaqServiceContract $faqServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $faqServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, FaqServiceContract $faqServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $faqServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
