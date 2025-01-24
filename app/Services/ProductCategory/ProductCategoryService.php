<?php

namespace App\Services\ProductCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\ProductCategory;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProductCategoryService implements ProductCategoryServiceContract
{
    public function get(int $id)
    {
        return ProductCategory::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $productCategoryDb = new ProductCategory();
            $productCategoryDb->name          = $request->name;
            $productCategoryDb->created_by    = Sentinel::getUser()->email;
            $productCategoryDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$productCategoryDb->name;
            $logDb->menu        = 'Product Category';
            $logDb->item_id     = $productCategoryDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $productCategoryDb;
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
            $productCategoryDb = ProductCategory::find($id);
            $productCategoryDb->name          = $request->name;
            $productCategoryDb->updated_by    = Sentinel::getUser()->email;
            $productCategoryDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$productCategoryDb->name;
            $logDb->menu        = 'Product Category';
            $logDb->item_id     = $productCategoryDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $productCategoryDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'product_category.*',
        ];

        $dataDb = ProductCategory::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('product_category.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('product_category.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('product_category.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $productCategoryDb = ProductCategory::where('id', $id)->first();
        if(!$productCategoryDb->product->isEmpty()){
            return '';
        }
        else{
            $productCategoryDb->deleted_by = Sentinel::getUser()->email;
            $productCategoryDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$productCategoryDb->name;
            $logDb->menu        = 'Product Category';
            $logDb->item_id     = $productCategoryDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return ProductCategory::where('id', $id)->delete();
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

            $count = ProductCategory::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = ProductCategory::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
