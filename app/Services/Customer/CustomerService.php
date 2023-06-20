<?php

namespace App\Services\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Customer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CustomerService implements CustomerServiceContract
{
    public function get(int $id)
    {
        return Customer::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $customerDb = new Customer();
            $customerDb->name           = $request->name;
            $customerDb->phone          = $request->phone;
            $customerDb->city_id        = $request->city_id;
            $customerDb->address        = $request->address;
            $customerDb->created_by     = Sentinel::getUser()->name;
            $customerDb->save();

            DB::commit();

            return $customerDb;
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
            $customerDb = Customer::find($id);
            $customerDb->name           = $request->name;
            $customerDb->phone          = $request->phone;
            $customerDb->city_id        = $request->city_id;
            $customerDb->address        = $request->address;
            $customerDb->updated_by     = Sentinel::getUser()->name;
            $customerDb->save();

            DB::commit();

            return $customerDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'customer.*',
        ];

        $dataDb = Customer::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('customer.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('customer.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name.' ('.$dataDb->phone.')']).'" data-href="'.route('customer.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $customerDb = Customer::where('id', $id)->first();
        $customerDb->deleted_by = Sentinel::getUser()->name;
        $customerDb->save();

        return Customer::where('id', $id)->delete();
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

            $count = Customer::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Customer::select('id', 'name as text', 'phone', 'city_id', 'address')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
