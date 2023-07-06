<?php

namespace App\Services\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Customer;
use App\Models\Log;
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
            if($request->city_id == null){
                $city_id = 0;
            }
            else{
                $city_id = $request->city_id;
            }

            $customerDb = new Customer();
            $customerDb->name           = $request->name;
            $customerDb->phone          = $request->phone;
            $customerDb->city_id        = $city_id;
            $customerDb->address        = $request->address;
            $customerDb->created_by     = Sentinel::getUser()->email;
            $customerDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$customerDb->name;
            $logDb->menu        = 'Customer';
            $logDb->item_id     = $customerDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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
            if($request->city_id == null){
                $city_id = 0;
            }
            else{
                $city_id = $request->city_id;
            }

            $customerDb = Customer::find($id);
            $customerDb->name           = $request->name;
            $customerDb->phone          = $request->phone;
            $customerDb->city_id        = $city_id;
            $customerDb->address        = $request->address;
            $customerDb->updated_by     = Sentinel::getUser()->email;
            $customerDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$customerDb->name;
            $logDb->menu        = 'Customer';
            $logDb->item_id     = $customerDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

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
                'city_name',
                function ($dataDb) {
                    if($dataDb->city){
                        return $dataDb->city->name;
                    }
                    else{
                        return '';
                    }
                }
            )
            ->addColumn(
                'province_name',
                function ($dataDb) {
                    if($dataDb->city){
                        return $dataDb->city->province->name;
                    }
                    else{
                        return '';
                    }
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->rawColumns(array('city_name', 'province_name', 'action'))
            ->make(true);
    }

    public function destroy(int $id)
    {
        $customerDb = Customer::where('id', $id)->first();
        if(!$customerDb->transaction->isEmpty()){
            return '';
        }
        else{
            $customerDb->deleted_by = Sentinel::getUser()->email;
            $customerDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$customerDb->name;
            $logDb->menu        = 'Customer';
            $logDb->item_id     = $customerDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return Customer::where('id', $id)->delete();
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

            $count = Customer::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Customer::select('id', 'phone as text', 'name', 'city_id', 'address')->where('phone', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
