<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\ProductCategory\productCategoryRequest;
use App\Services\ProductCategory\ProductCategoryServiceContract;
use App\Traits\redirectTo;
use App\Models\ProductCategory;
use App\Models\Log;

class ProductCategoryController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.product_category.index');
    }

    public function show($id, ProductCategoryServiceContract $productCategoryServiceContract)
    {
        return view('backend.product_category.detail', ['product_category' => $productCategoryServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.product_category.create');
    }

    public function store(productCategoryRequest $request, ProductCategoryServiceContract $productCategoryServiceContract)
    {
        #Save Product Category Data
        if (is_object($productCategoryServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('product_category.index'), 'Product Category');
        } else {

            #Bump....
            return $this->redirectFailed(route('product_category.index'), 'Failed To Save Product Category');
        }
    }

    public function edit($id, ProductCategoryServiceContract $productCategoryServiceContract)
    {
        $product_category = $productCategoryServiceContract->get($id);
        return view('backend.product_category.update', compact('product_category'));
    }

    public function update(productCategoryRequest $request, $id, ProductCategoryServiceContract $productCategoryServiceContract)
    {
        #Save Product Category Data
        if (is_object($productCategoryServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('product_category.index'), 'Product Category');
        } else {

            #Bump....
            return $this->redirectFailed(route('product_category.index'), 'Failed To Save Product Category');
        }
    }

    public function destroy($id, ProductCategoryServiceContract $productCategoryServiceContract)
    {
        if($productCategoryServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('product_category.index'), 'Product Category');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('product_category.index'), 'Failed To Delete Product Category because there is data connected');
        }
    }

    public function datatable(Request $request, ProductCategoryServiceContract $productCategoryServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $productCategoryServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, ProductCategoryServiceContract $productCategoryServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $productCategoryServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
