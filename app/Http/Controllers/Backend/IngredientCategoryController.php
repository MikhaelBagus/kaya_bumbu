<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\IngredientCategory\ingredientCategoryRequest;
use App\Services\IngredientCategory\IngredientCategoryServiceContract;
use App\Traits\redirectTo;
use App\Models\IngredientMasterCategory;
use App\Models\Log;

class IngredientCategoryController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.ingredient_category.index');
    }

    public function show($id, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {
        return view('backend.ingredient_category.detail', ['ingredient_category' => $ingredientCategoryServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.ingredient_category.create');
    }

    public function store(ingredientCategoryRequest $request, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {
        #Save Ingredient Category Data
        if (is_object($ingredientCategoryServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('ingredient_category.index'), 'Ingredient Category');
        } else {

            #Bump....
            return $this->redirectFailed(route('ingredient_category.index'), 'Failed To Save Ingredient Category');
        }
    }

    public function edit($id, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {
        $ingredient_category = $ingredientCategoryServiceContract->get($id);
        return view('backend.ingredient_category.update', compact('ingredient_category'));
    }

    public function update(ingredientCategoryRequest $request, $id, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {
        #Save Ingredient Category Data
        if (is_object($ingredientCategoryServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('ingredient_category.index'), 'Ingredient Category');
        } else {

            #Bump....
            return $this->redirectFailed(route('ingredient_category.index'), 'Failed To Save Ingredient Category');
        }
    }

    public function destroy($id, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {
        if($ingredientCategoryServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('ingredient_category.index'), 'Ingredient Category');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('ingredient_category.index'), 'Failed To Delete Ingredient Category because there is data connected');
        }
    }

    public function datatable(Request $request, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $ingredientCategoryServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, IngredientCategoryServiceContract $ingredientCategoryServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $ingredientCategoryServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
