<?php

namespace App\Services\Supplier;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\SupplierAccount;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SupplierService implements SupplierServiceContract
{
    public function get(int $id)
    {
        return Supplier::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $supplierDb = new Supplier();
            $supplierDb->supplier_name        = $request->supplier_name;
            $supplierDb->supplier_phone       = $request->supplier_phone;
            $supplierDb->supplier_description = $request->supplier_description;
            $supplierDb->created_by         = Sentinel::getUser()->email;
            $supplierDb->save();

            $supplierAccountDb = new SupplierAccount();
            $supplierAccountDb->supplier_id    = $supplierDb->id;
            $supplierAccountDb->account_number = $request->supplier_account_number;
            $supplierAccountDb->account_name   = $request->supplier_account_name;
            $supplierAccountDb->bank_name      = $request->supplier_account_bank_name;
            $supplierAccountDb->description    = null;
            $supplierAccountDb->created_by     = Sentinel::getUser()->email;
            $supplierAccountDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$supplierDb->supplier_name;
            $logDb->menu        = 'Supplier';
            $logDb->item_id     = $supplierDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$supplierAccountDb->account_name;
            $logDb->menu        = 'Supplier Account';
            $logDb->item_id     = $supplierAccountDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $supplierDb;
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
            $supplierDb = Supplier::find($id);
            $supplierDb->supplier_name        = $request->supplier_name;
            $supplierDb->supplier_phone       = $request->supplier_phone;
            $supplierDb->supplier_description = $request->supplier_description;
            $supplierDb->updated_by         = Sentinel::getUser()->email;
            $supplierDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$supplierDb->supplier_name;
            $logDb->menu        = 'Supplier';
            $logDb->item_id     = $supplierDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $supplierDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'supplier.*',
        ];

        $dataDb = Supplier::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('supplier.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('supplier.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->supplier_name]).'" data-href="'.route('supplier.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $supplierDb = Supplier::where('id', $id)->first();
        if(!$supplierDb->supplierAccounts->isEmpty()){
            return '';
        }
        else if(!$supplierDb->purchase->isEmpty()){
            return '';
        }
        else{
            $supplierDb->deleted_by = Sentinel::getUser()->email;
            $supplierDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$supplierDb->supplier_name;
            $logDb->menu        = 'Supplier';
            $logDb->item_id     = $supplierDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return Supplier::where('id', $id)->delete();
        }
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

            $count = Supplier::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Supplier::select('id', DB::raw('supplier_name as text'), 'supplier_phone')
                ->where('supplier_name', 'LIKE', '%'.$term.'%')
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
