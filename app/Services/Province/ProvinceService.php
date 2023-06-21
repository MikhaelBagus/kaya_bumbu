<?php

namespace App\Services\Province;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Province;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProvinceService implements ProvinceServiceContract
{
    public function get(int $id)
    {
        return Province::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $provinceDb = new Province();
            $provinceDb->name          = $request->name;
            $provinceDb->created_by    = Sentinel::getUser()->email;
            $provinceDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$provinceDb->name;
            $logDb->menu        = 'Province';
            $logDb->item_id     = $provinceDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $provinceDb;
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
            $provinceDb = Province::find($id);
            $provinceDb->name          = $request->name;
            $provinceDb->updated_by    = Sentinel::getUser()->email;
            $provinceDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$provinceDb->name;
            $logDb->menu        = 'Province';
            $logDb->item_id     = $provinceDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $provinceDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'province.*',
        ];

        $dataDb = Province::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('province.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('province.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('province.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $provinceDb = Province::where('id', $id)->first();
        $provinceDb->deleted_by = Sentinel::getUser()->email;
        $provinceDb->save();

        $logDb = new Log();
        $logDb->user_id     = Sentinel::getUser()->id;
        $logDb->action      = 'Delete '.$provinceDb->name;
        $logDb->menu        = 'Province';
        $logDb->item_id     = $provinceDb->id;
        $logDb->created_by  = Sentinel::getUser()->email;
        $logDb->save();

        return Province::where('id', $id)->delete();
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

            $count = Province::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Province::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
