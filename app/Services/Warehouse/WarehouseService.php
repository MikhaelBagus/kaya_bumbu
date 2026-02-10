<?php

namespace App\Services\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class WarehouseService implements WarehouseServiceContract
{
    public function get(int $id)
    {
        return Warehouse::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $warehouseDb = new Warehouse();
            $warehouseDb->warehouse_name        = $request->warehouse_name;
            $warehouseDb->warehouse_description = $request->warehouse_description;
            $warehouseDb->created_by         = Sentinel::getUser()->email;
            $warehouseDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$warehouseDb->warehouse_name;
            $logDb->menu        = 'Warehouse';
            $logDb->item_id     = $warehouseDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $warehouseDb;
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
            $warehouseDb = Warehouse::find($id);
            $warehouseDb->warehouse_name        = $request->warehouse_name;
            $warehouseDb->warehouse_description = $request->warehouse_description;
            $warehouseDb->updated_by         = Sentinel::getUser()->email;
            $warehouseDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$warehouseDb->warehouse_name;
            $logDb->menu        = 'Warehouse';
            $logDb->item_id     = $warehouseDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $warehouseDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'warehouse.*',
        ];

        $dataDb = Warehouse::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('warehouse.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('warehouse.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->warehouse_name]).'" data-href="'.route('warehouse.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $warehouseDb = Warehouse::where('id', $id)->first();

        $warehouseDb->deleted_by = Sentinel::getUser()->email;
        $warehouseDb->save();

        $logDb = new Log();
        $logDb->user_id     = Sentinel::getUser()->id;
        $logDb->action      = 'Delete '.$warehouseDb->warehouse_name;
        $logDb->menu        = 'Warehouse';
        $logDb->item_id     = $warehouseDb->id;
        $logDb->created_by  = Sentinel::getUser()->email;
        $logDb->save();

        return Warehouse::where('id', $id)->delete();
    }

    public function select2($request)
    {
        try {
            $perPage = 10;
            $page    = $request->page ?? 1;

            // Handle search term from either 'term' or 'search.term'
            $term = '';
            if ($request->has('term')) {
                $term = $request->term;
            } elseif ($request->has('search') && is_array($request->search) && isset($request->search['term'])) {
                $term = $request->search['term'];
            }

            Paginator::currentPageResolver(
                function () use ($page) {
                    return $page;
                }
            );

            $count = Warehouse::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Warehouse::select('id', DB::raw('warehouse_name as text'))
                ->where('warehouse_name', 'LIKE', '%'.$term.'%')
                ->orderBy('text')
                ->paginate($perPage);

            // Convert to Select2 format
            return response()->json([
                'results' => $dataDb->items(),
                'pagination' => [
                    'more' => $dataDb->hasMorePages()
                ]
            ]);
        }
        catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
