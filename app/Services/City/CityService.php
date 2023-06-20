<?php

namespace App\Services\City;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\City;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CityService implements CityServiceContract
{
    public function get(int $id)
    {
        return City::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $cityDb = new City();
            $cityDb->province_id   = $request->province_id;
            $cityDb->name          = $request->name;
            $cityDb->created_by    = Sentinel::getUser()->name;
            $cityDb->save();

            DB::commit();

            return $cityDb;
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
            $cityDb = City::find($id);
            $cityDb->province_id   = $request->province_id;
            $cityDb->name          = $request->name;
            $cityDb->updated_by    = Sentinel::getUser()->name;
            $cityDb->save();

            DB::commit();

            return $cityDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'city.*',
        ];

        $dataDb = City::select($select)->with('province');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('city.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('city.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('city.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $cityDb = City::where('id', $id)->first();
        $cityDb->deleted_by = Sentinel::getUser()->name;
        $cityDb->save();

        return City::where('id', $id)->delete();
    }

    public function select2($request)
    {
        try {
            $perPage = 10;
            $page    = $request->page ?? 1;
            $term = $request->term;
            $province_id = $request->province_id;

            Paginator::currentPageResolver(
                function () use ($page) {
                    return $page;
                }
            );

            $count = City::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = City::select('id', 'name as text')->province($province_id)->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
