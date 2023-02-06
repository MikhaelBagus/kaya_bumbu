<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\Ingredient\ingredientRequest;
use App\Services\Ingredient\IngredientServiceContract;
use App\Traits\redirectTo;

class IngredientController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.ingredient.index');
    }

    public function show($id, IngredientServiceContract $ingredientServiceContract)
    {
        return view('backend.ingredient.detail', ['ingredient' => $ingredientServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.ingredient.create');
    }

    public function store(ingredientRequest $request, IngredientServiceContract $ingredientServiceContract)
    {
        #Save Ingredient Data
        if (is_object($ingredientServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('ingredient.index'), 'Ingredient');
        } else {

            #Bump....
            return $this->redirectFailed(route('ingredient.index'), 'Failed To Save Ingredient');
        }
    }

    public function edit($id, IngredientServiceContract $ingredientServiceContract)
    {
        $ingredient = $ingredientServiceContract->get($id);
        return view('backend.ingredient.update', compact('ingredient'));
    }

    public function update(ingredientRequest $request, $id, IngredientServiceContract $ingredientServiceContract)
    {
        #Save Ingredient Data
        if (is_object($ingredientServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('ingredient.index'), 'Ingredient');
        } else {

            #Bump....
            return $this->redirectFailed(route('ingredient.index'), 'Failed To Save Ingredient');
        }
    }

    public function destroy($id, IngredientServiceContract $ingredientServiceContract)
    {
        #Get services for bulk delete
        $ingredientServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('ingredient.index'), 'Ingredient');
    }

    public function bulkDestroy(Request $request, IngredientServiceContract $ingredientServiceContract)
    {
        #Get services for bulk delete
        $ingredientServiceContract->destroyBulk($request->id);

        #Bump....
        return $this->redirectSuccessDelete(route('ingredient.index'), 'Ingredient');
    }

    public function datatable(Request $request, IngredientServiceContract $ingredientServiceContract)
    {

        if ($request->ajax()) {
            # Return The JSON datatables Data
            return $ingredientServiceContract->datatable($request);
        }

        abort('404', 'uups');
    }

    public function select2(Request $request, IngredientServiceContract $ingredientServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $ingredientServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
