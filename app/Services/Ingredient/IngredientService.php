<?php

namespace App\Services\Ingredient;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Ingredient;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class IngredientService implements IngredientServiceContract
{
    public function get(int $id)
    {
        return Ingredient::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $date = date('ymd');
            $ingredient = Ingredient::orderBy('id','desc')->first();

            if($ingredient == null){
                $id = 1;
            }
            else{
                $code_last = substr($ingredient->code,-4);
                $code_date = substr($ingredient->code, 0 ,6);
                if($code_date == $date){
                    $id = (int)$code_last +1;

                }
                else{
                    $id = 1;
                }
            }
            $ingredient_code_new = $date.sprintf("%04d", $id);

            $ingredientDb = new Ingredient();
            $ingredientDb->code        = $ingredient_code_new;
            $ingredientDb->name        = $request->name;
            $ingredientDb->stock       = $request->stock;
            $ingredientDb->unit        = $request->unit;
            $ingredientDb->created_by  = Sentinel::getUser()->name;
            $ingredientDb->save();

            DB::commit();

            return $ingredientDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function update(int $id, $request)
    {
        DB::beginTransaction();

        try {
            $ingredientDb = Ingredient::find($id);
            $ingredientDb->name        = $request->name;
            $ingredientDb->stock       = $request->stock;
            $ingredientDb->unit        = $request->unit;
            $ingredientDb->updated_by  = Sentinel::getUser()->name;
            $ingredientDb->save();

            DB::commit();

            return $ingredientDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'ingredient.*',
        ];

        $dataDb = Ingredient::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('ingredient.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('ingredient.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('ingredient.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->make(true);
    }

    public function destroy(int $id)
    {
        $ingredientDb = Ingredient::where('id', $id)->first();
        $ingredientDb->deleted_by = Sentinel::getUser()->name;
        $ingredientDb->save();

        return Ingredient::where('id', $id)->delete();
    }

    public function select2($request)
    {
        try {
            $perPage = 10;
            $page    = $request->page ?? 1;
            $term = $request->term;

            Paginator::currentPageResolver(
                function () use ($page) {
                    return $page;
                }
            );

            $count = Ingredient::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Ingredient::select('id', 'name as text', 'code', 'stock', 'unit')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
