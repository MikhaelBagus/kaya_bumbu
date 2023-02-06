<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Media\mediaRequest;
use App\Services\Media\MediaServiceContract;
use App\Traits\redirectTo;

class MediaController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.media.index');
    }

    public function show($id, MediaServiceContract $mediaServiceContract)
    {
        return view('backend.media.detail', ['media' => $mediaServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.media.create');
    }

    public function store(mediaRequest $request, MediaServiceContract $mediaServiceContract)
    {
        #Save Media Data
        if (is_object($mediaServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('media.index'), 'Media');
        } else {

            #Bump....
            return $this->redirectFailed(route('media.index'), 'Failed To Save Media');
        }
    }

    public function edit($id, MediaServiceContract $mediaServiceContract)
    {
        $media = $mediaServiceContract->get($id);
        return view('backend.media.update', compact('media'));
    }

    public function update(mediaRequest $request, $id, MediaServiceContract $mediaServiceContract)
    {
        #Save Media Data
        if (is_object($mediaServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('media.index'), 'Media');
        } else {

            #Bump....
            return $this->redirectFailed(route('media.index'), 'Failed To Save Media');
        }
    }

    public function destroy($id, MediaServiceContract $mediaServiceContract)
    {
        #Get services for bulk delete
        $mediaServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('media.index'), 'Media');
    }

    public function bulkDestroy(Request $request, MediaServiceContract $mediaServiceContract)
    {
        #Get services for bulk delete
        $mediaServiceContract->destroyBulk($request->id);

        #Bump....
        return $this->redirectSuccessDelete(route('media.index'), 'Media');
    }

    public function datatable(Request $request, MediaServiceContract $mediaServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $mediaServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, MediaServiceContract $mediaServiceContract)
    {

        if ($request->ajax() === true) {

            return $mediaServiceContract->select2($request);
        }

        return abort('404', 'uups');
    }
}
