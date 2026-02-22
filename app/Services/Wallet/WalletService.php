<?php

namespace App\Services\Wallet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class WalletService implements WalletServiceContract
{
    public function get(int $id)
    {
        return Wallet::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $walletDb = new Wallet();
            $walletDb->account_number = $request->account_number;
            $walletDb->account_name   = $request->account_name;
            $walletDb->bank_name      = $request->bank_name;
            $walletDb->description    = $request->description;
            $walletDb->created_by     = Sentinel::getUser()->email;
            $walletDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$walletDb->account_name;
            $logDb->menu        = 'Wallet';
            $logDb->item_id     = $walletDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $walletDb;
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
            $walletDb = Wallet::find($id);
            $walletDb->account_number = $request->account_number;
            $walletDb->account_name   = $request->account_name;
            $walletDb->bank_name      = $request->bank_name;
            $walletDb->description    = $request->description;
            $walletDb->updated_by     = Sentinel::getUser()->email;
            $walletDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$walletDb->account_name;
            $logDb->menu        = 'Wallet';
            $logDb->item_id     = $walletDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $walletDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'wallet.*',
        ];

        $dataDb = Wallet::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('wallet.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('wallet.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->account_name]).'" data-href="'.route('wallet.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $walletDb = Wallet::where('id', $id)->first();
        $walletDb->deleted_by = Sentinel::getUser()->email;
        $walletDb->save();

        $logDb = new Log();
        $logDb->user_id     = Sentinel::getUser()->id;
        $logDb->action      = 'Delete '.$walletDb->account_name;
        $logDb->menu        = 'Wallet';
        $logDb->item_id     = $walletDb->id;
        $logDb->created_by  = Sentinel::getUser()->email;
        $logDb->save();

        return Wallet::where('id', $id)->delete();
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

            $query = Wallet::select(
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
            return $exception->getCode();
        }
    }

    public function select2Old($request)
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

            $count = Wallet::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Wallet::select('id', DB::raw('concat(bank_name, " ", account_number, " a/n ", account_name) as text'))->where('bank_name', 'LIKE', '%'.$request->term.'%')->orWhere('account_name', 'LIKE', '%'.$request->term.'%')->orWhere('account_number', 'LIKE', '%'.$request->term.'%')->orderBy('text')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getMessage();
        }
    }
}
