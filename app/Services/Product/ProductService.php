<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Product;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProductService implements ProductServiceContract
{
    public function get(int $id)
    {
        return Product::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $productDb = new Product();
            $productDb->product_category_id = $request->product_category_id;
            $productDb->name          = $request->name;
            $productDb->price         = $request->price;
            $productDb->unit          = $request->unit;
            $productDb->value         = $request->value;
            $productDb->created_by    = Sentinel::getUser()->email;
            $productDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$productDb->name;
            $logDb->menu        = 'Product';
            $logDb->item_id     = $productDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $productDb;
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
            $productDb = Product::find($id);
            $productDb->product_category_id = $request->product_category_id;
            $productDb->name          = $request->name;
            $productDb->price         = $request->price;
            $productDb->unit          = $request->unit;
            $productDb->value         = $request->value;
            $productDb->updated_by    = Sentinel::getUser()->email;
            $productDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$productDb->name;
            $logDb->menu        = 'Product';
            $logDb->item_id     = $productDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $productDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'product.*',
        ];

        $dataDb = Product::select($select)->with('product_category');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('product.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('product.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('product.copy', [$dataDb->id]).'" id="tooltip" title="Copy"><span class="label label-warning label-sm">Copy</span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('product.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $productDb = Product::where('id', $id)->first();
        if(!$productDb->transaction_product->isEmpty()){
            return '';
        }
        else{
            $productDb->deleted_by = Sentinel::getUser()->email;
            $productDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$productDb->name;
            $logDb->menu        = 'Product';
            $logDb->item_id     = $productDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return Product::where('id', $id)->delete();
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

            $count = Product::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Product::select('id', 'name as text', 'price', 'unit', 'value')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
