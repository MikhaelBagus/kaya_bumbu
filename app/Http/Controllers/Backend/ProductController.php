<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Product\productRequest;
use App\Services\Product\ProductServiceContract;
use App\Traits\redirectTo;

class ProductController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.product.index');
    }

    public function show($id, ProductServiceContract $productServiceContract)
    {
        return view('backend.product.detail', ['product' => $productServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.product.create');
    }

    public function store(productRequest $request, ProductServiceContract $productServiceContract)
    {
        #Save Product Data
        if (is_object($productServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('product.index'), 'Product');
        } else {

            #Bump....
            return $this->redirectFailed(route('product.index'), 'Failed To Save Product');
        }
    }

    public function edit($id, ProductServiceContract $productServiceContract)
    {
        $product = $productServiceContract->get($id);
        return view('backend.product.update', compact('product'));
    }

    public function update(productRequest $request, $id, ProductServiceContract $productServiceContract)
    {
        #Save Product Data
        if (is_object($productServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('product.index'), 'Product');
        } else {

            #Bump....
            return $this->redirectFailed(route('product.index'), 'Failed To Save Product');
        }
    }

    public function destroy($id, ProductServiceContract $productServiceContract)
    {
        if($productServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('product.index'), 'Product');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('product.index'), 'Failed To Delete Product because there is data connected');
        }
    }

    public function datatable(Request $request, ProductServiceContract $productServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $productServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, ProductServiceContract $productServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $productServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
