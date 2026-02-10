<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\IngredientGroup\ingredientGroupRequest;
use App\Services\IngredientGroup\IngredientGroupServiceContract;
use App\Traits\redirectTo;

class IngredientGroupController extends Controller
{
    use redirectTo;

    public function index()
    {
        return view('backend.ingredient_group.index');
    }

    public function show($id, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        return view('backend.ingredient_group.detail', ['ingredient_group' => $ingredientGroupServiceContract->get($id)]);
    }

    public function create()
    {
        return view('backend.ingredient_group.create');
    }

    public function store(ingredientGroupRequest $request, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        #Save Ingredient Group Data
        if (is_object($ingredientGroupServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('ingredient_group.index'), 'Ingredient Group');
        } else {

            #Bump....
            return $this->redirectFailed(route('ingredient_group.index'), 'Failed To Save Ingredient Group');
        }
    }

    public function edit($id, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        $ingredient_group = $ingredientGroupServiceContract->get($id);
        return view('backend.ingredient_group.update', compact('ingredient_group'));
    }

    public function update(ingredientGroupRequest $request, $id, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        #Save Ingredient Group Data
        if (is_object($ingredientGroupServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('ingredient_group.index'), 'Ingredient Group');
        } else {

            #Bump....
            return $this->redirectFailed(route('ingredient_group.index'), 'Failed To Save Ingredient Group');
        }
    }

    public function destroy($id, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        if($ingredientGroupServiceContract->destroy($id) != ''){
            #Bump....
            return $this->redirectSuccessDelete(route('ingredient_group.index'), 'Ingredient Group');
        }
        else{
            #Bump....
            return $this->redirectFailed(route('ingredient_group.index'), 'Failed To Delete Ingredient Group');
        }
    }

    public function datatable(Request $request, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $ingredientGroupServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function select2(Request $request, IngredientGroupServiceContract $ingredientGroupServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {

                return $ingredientGroupServiceContract->select2($request);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
