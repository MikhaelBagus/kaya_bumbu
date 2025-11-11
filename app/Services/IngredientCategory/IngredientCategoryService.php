<?php

namespace App\Services\IngredientCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\IngredientCategory;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class IngredientCategoryService implements IngredientCategoryServiceContract
{
    public function get(int $id)
    {
        return IngredientCategory::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $ingredientCategoryDb = new IngredientCategory();
            $ingredientCategoryDb->name          = $request->name;
            $ingredientCategoryDb->created_by    = Sentinel::getUser()->email;
            $ingredientCategoryDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$ingredientCategoryDb->name;
            $logDb->menu        = 'Ingredient Category';
            $logDb->item_id     = $ingredientCategoryDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $ingredientCategoryDb;
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
            $ingredientCategoryDb = IngredientCategory::find($id);
            $ingredientCategoryDb->name          = $request->name;
            $ingredientCategoryDb->updated_by    = Sentinel::getUser()->email;
            $ingredientCategoryDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$ingredientCategoryDb->name;
            $logDb->menu        = 'Ingredient Category';
            $logDb->item_id     = $ingredientCategoryDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $ingredientCategoryDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'ingredient_master_categories.*',
        ];

        $dataDb = IngredientCategory::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('ingredient_category.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('ingredient_category.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('ingredient_category.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $ingredientCategoryDb = IngredientCategory::where('id', $id)->first();
        if(!$ingredientCategoryDb->ingredient->isEmpty()){
            return '';
        }
        else{
            $ingredientCategoryDb->deleted_by = Sentinel::getUser()->email;
            $ingredientCategoryDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$ingredientCategoryDb->name;
            $logDb->menu        = 'Ingredient Category';
            $logDb->item_id     = $ingredientCategoryDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return IngredientCategory::where('id', $id)->delete();
        }
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

            $count = IngredientCategory::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = IngredientCategory::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
