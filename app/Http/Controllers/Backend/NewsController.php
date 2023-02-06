<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\News\newsRequest;
use App\Services\News\NewsServiceContract;
use App\Traits\redirectTo;

class NewsController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.news.index');
    }

    public function show($id, NewsServiceContract $newsServiceContract)
    {
        return view('backend.news.detail', ['news' => $newsServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.news.create');
    }

    public function store(newsRequest $request, NewsServiceContract $newsServiceContract)
    {
        #Save News Data
        if (is_object($newsServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('news.index'), 'News');
        } else {

            #Bump....
            return $this->redirectFailed(route('news.index'), 'Failed To Save News');
        }
    }

    public function edit($id, NewsServiceContract $newsServiceContract)
    {
        $news = $newsServiceContract->get($id);
        return view('backend.news.update', compact('news'));
    }

    public function update(newsRequest $request, $id, NewsServiceContract $newsServiceContract)
    {
        #Save News Data
        if (is_object($newsServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('news.index'), 'News');
        } else {

            #Bump....
            return $this->redirectFailed(route('news.index'), 'Failed To Save News');
        }
    }

    public function destroy($id, NewsServiceContract $newsServiceContract)
    {
        #Get services for bulk delete
        $newsServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('news.index'), 'News');
    }

    public function datatable(Request $request, NewsServiceContract $newsServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $newsServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
