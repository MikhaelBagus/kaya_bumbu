<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Product;
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
            $productDb->name          = $request->name;
            $productDb->price         = $request->price;
            $productDb->unit          = $request->unit;
            $productDb->created_by    = Sentinel::getUser()->email;
            $productDb->save();

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
            $productDb->name          = $request->name;
            $productDb->price         = $request->price;
            $productDb->unit          = $request->unit;
            $productDb->updated_by    = Sentinel::getUser()->email;
            $productDb->save();

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

        $dataDb = Product::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('product.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('product.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('product.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $productDb->deleted_by = Sentinel::getUser()->email;
        $productDb->save();

        return Product::where('id', $id)->delete();
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

            $dataDb = Product::select('id', 'name as text', 'price', 'unit')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
