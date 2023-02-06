<?php

namespace App\Services\Disclaimer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Disclaimer;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Purifier;

class DisclaimerService implements DisclaimerServiceContract
{
    public function get(int $id)
    {
        return Disclaimer::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $disclaimerDb = new Disclaimer();
            $disclaimerDb->content     = Purifier::clean($request->content);
            $disclaimerDb->publish     = 1;
            $disclaimerDb->created_by  = Sentinel::getUser()->name;
            $disclaimerDb->save();

            DB::commit();

            return $disclaimerDb;
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
            $disclaimerDb = Disclaimer::find($id);
            $disclaimerDb->content     = Purifier::clean($request->content);
            $disclaimerDb->publish     = 1;
            $disclaimerDb->updated_by  = Sentinel::getUser()->name;
            $disclaimerDb->save();

            DB::commit();

            return $disclaimerDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'disclaimer.*',
        ];

        $dataDb = Disclaimer::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('disclaimer.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('disclaimer.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
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
        $disclaimerDb = Disclaimer::where('id', $id)->first();
        $disclaimerDb->deleted_by = Sentinel::getUser()->name;
        $disclaimerDb->save();

        return Disclaimer::where('id', $id)->delete();
    }

    public function destroyBulk(array $id)
    {
        return Disclaimer::whereIn('id', $id)->delete();
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

            $count = Disclaimer::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Disclaimer::select('id', 'content as text')->where('content', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
