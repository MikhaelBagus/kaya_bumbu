<?php

namespace App\Services\Bank;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Bank;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class BankService implements BankServiceContract
{
    public function get(int $id)
    {
        return Bank::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $bankDb = new Bank();
            $bankDb->bank_name      = $request->bank_name;
            $bankDb->account_number = $request->account_number;
            $bankDb->account_name   = $request->account_name;
            $bankDb->created_by     = Sentinel::getUser()->email;
            $bankDb->save();

            DB::commit();

            return $bankDb;
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
            $bankDb = Bank::find($id);
            $bankDb->bank_name      = $request->bank_name;
            $bankDb->account_number = $request->account_number;
            $bankDb->account_name   = $request->account_name;
            $bankDb->updated_by     = Sentinel::getUser()->email;
            $bankDb->save();

            DB::commit();

            return $bankDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'bank.*',
        ];

        $dataDb = Bank::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('bank.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('bank.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->bank_name.' '.$dataDb->account_number.' a\n '.$dataDb->account_name]).'" data-href="'.route('bank.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $bankDb = Bank::where('id', $id)->first();
        $bankDb->deleted_by = Sentinel::getUser()->email;
        $bankDb->save();

        return Bank::where('id', $id)->delete();
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

            $count = Bank::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Bank::select('id', DB::raw('concat(bank_name, " a/n ", account_name, " ", account_number) as text'))->where('bank_name', 'LIKE', '%'.$request->term.'%')->orWhere('account_name', 'LIKE', '%'.$request->term.'%')->orWhere('account_number', 'LIKE', '%'.$request->term.'%')->orderBy('text')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
