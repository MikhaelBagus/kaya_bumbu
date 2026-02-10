<?php

namespace App\Services\SupplierAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierAccount;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SupplierAccountService implements SupplierAccountServiceContract
{
    public function get(int $id)
    {
        return SupplierAccount::with('supplier')->find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $supplierAccountDb = new SupplierAccount();
            $supplierAccountDb->supplier_id    = $request->supplier_id;
            $supplierAccountDb->account_number = $request->account_number;
            $supplierAccountDb->account_name   = $request->account_name;
            $supplierAccountDb->bank_name      = $request->bank_name;
            $supplierAccountDb->description    = $request->description;
            $supplierAccountDb->created_by     = Sentinel::getUser()->email;
            $supplierAccountDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$supplierAccountDb->account_name;
            $logDb->menu        = 'Supplier Account';
            $logDb->item_id     = $supplierAccountDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $supplierAccountDb;
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
            $supplierAccountDb = SupplierAccount::find($id);
            $supplierAccountDb->supplier_id    = $request->supplier_id;
            $supplierAccountDb->account_number = $request->account_number;
            $supplierAccountDb->account_name   = $request->account_name;
            $supplierAccountDb->bank_name      = $request->bank_name;
            $supplierAccountDb->description    = $request->description;
            $supplierAccountDb->updated_by     = Sentinel::getUser()->email;
            $supplierAccountDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$supplierAccountDb->account_name;
            $logDb->menu        = 'Supplier Account';
            $logDb->item_id     = $supplierAccountDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $supplierAccountDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'supplier_accounts.*',
            'supplier.supplier_name',
        ];

        $dataDb = SupplierAccount::select($select)
            ->join('supplier', 'supplier.id', '=', 'supplier_accounts.supplier_id');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('supplier_account.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('supplier_account.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->account_name]).'" data-href="'.route('supplier_account.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $supplierAccountDb = SupplierAccount::where('id', $id)->first();
        if(!$supplierAccountDb->purchase->isEmpty()){
            return '';
        }
        else{
            $supplierAccountDb->deleted_by = Sentinel::getUser()->email;
            $supplierAccountDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$supplierAccountDb->account_name;
            $logDb->menu        = 'Supplier Account';
            $logDb->item_id     = $supplierAccountDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return SupplierAccount::where('id', $id)->delete();
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

            $query = SupplierAccount::select(
                'id',
                'account_number',
                'account_name',
                'bank_name',
                DB::raw("CONCAT(account_number, ' - ', account_name, ' - ', bank_name) as text")
            )->where(function($q) use ($term) {
                $q->where('account_number', 'LIKE', '%'.$term.'%')
                  ->orWhere('account_name', 'LIKE', '%'.$term.'%')
                  ->orWhere('bank_name', 'LIKE', '%'.$term.'%');
            });

            // Filter by supplier_id if provided
            if ($request->has('supplier_id') && $request->supplier_id) {
                $query->where('supplier_id', $request->supplier_id);
            }

            $count = $query->count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = $query->orderBy('account_number')->paginate($perPage);

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
