<?php

namespace App\Services\Driver;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Driver;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class DriverService implements DriverServiceContract
{
    public function get(int $id)
    {
        return Driver::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $driverDb = new Driver();
            $driverDb->name          = $request->name;
            $driverDb->created_by    = Sentinel::getUser()->email;
            $driverDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$driverDb->name;
            $logDb->menu        = 'Driver';
            $logDb->item_id     = $driverDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $driverDb;
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
            $driverDb = Driver::find($id);
            $driverDb->name          = $request->name;
            $driverDb->updated_by    = Sentinel::getUser()->email;
            $driverDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$driverDb->name;
            $logDb->menu        = 'Driver';
            $logDb->item_id     = $driverDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $driverDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'driver.*',
        ];

        $dataDb = Driver::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('driver.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('driver.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('driver.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $driverDb = Driver::where('id', $id)->first();
        if(!$driverDb->transaction->isEmpty()){
            return '';
        }
        else{
            $driverDb->deleted_by = Sentinel::getUser()->email;
            $driverDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$driverDb->name;
            $logDb->menu        = 'Driver';
            $logDb->item_id     = $driverDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return Driver::where('id', $id)->delete();
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

            $count = Driver::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Driver::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
