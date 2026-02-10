<?php

namespace App\Services\IngredientGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\IngredientGroup;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class IngredientGroupService implements IngredientGroupServiceContract
{
    public function get(int $id)
    {
        return IngredientGroup::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $ingredientGroupDb = new IngredientGroup();
            $ingredientGroupDb->name          = $request->name;
            $ingredientGroupDb->created_by    = Sentinel::getUser()->email;
            $ingredientGroupDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$ingredientGroupDb->name;
            $logDb->menu        = 'Ingredient Group';
            $logDb->item_id     = $ingredientGroupDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $ingredientGroupDb;
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
            $ingredientGroupDb = IngredientGroup::find($id);
            $ingredientGroupDb->name          = $request->name;
            $ingredientGroupDb->updated_by    = Sentinel::getUser()->email;
            $ingredientGroupDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$ingredientGroupDb->name;
            $logDb->menu        = 'Ingredient Group';
            $logDb->item_id     = $ingredientGroupDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $ingredientGroupDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'ingredient_master_groups.*',
        ];

        $dataDb = IngredientGroup::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('ingredient_group.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('v.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('ingredient_group.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $ingredientGroupDb = IngredientGroup::where('id', $id)->first();
        if(!$ingredientGroupDb->category->isEmpty()){
            return '';
        }
        else{
            $ingredientGroupDb->deleted_by = Sentinel::getUser()->email;
            $ingredientGroupDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$ingredientGroupDb->name;
            $logDb->menu        = 'Ingredient Group';
            $logDb->item_id     = $ingredientGroupDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return IngredientGroup::where('id', $id)->delete();
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

            $count = IngredientGroup::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = IngredientGroup::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
