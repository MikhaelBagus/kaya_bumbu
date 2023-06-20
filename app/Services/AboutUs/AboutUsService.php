<?php

namespace App\Services\AboutUs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\AboutUs;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Purifier;

class AboutUsService implements AboutUsServiceContract
{
    public function get(int $id)
    {
        return AboutUs::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $aboutUsDb = new AboutUs();
            $aboutUsDb->content     = Purifier::clean($request->content);
            $aboutUsDb->created_by  = Sentinel::getUser()->email;
            $aboutUsDb->save();

            DB::commit();

            return $aboutUsDb;
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
            $aboutUsDb = AboutUs::find($id);
            $aboutUsDb->content     = Purifier::clean($request->content);
            $aboutUsDb->updated_by  = Sentinel::getUser()->email;
            $aboutUsDb->save();

            DB::commit();

            return $aboutUsDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'about_us.*',
        ];

        $dataDb = AboutUs::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('about_us.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('about_us.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->rawColumns(array('content','action'))
            ->make(true);
    }

    public function destroy(int $id)
    {
        $aboutUsDb = AboutUs::where('id', $id)->first();
        $aboutUsDb->deleted_by = Sentinel::getUser()->email;
        $aboutUsDb->save();

        return AboutUs::where('id', $id)->delete();
    }
}
