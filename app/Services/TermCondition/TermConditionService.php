<?php

namespace App\Services\TermCondition;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\TermCondition;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Purifier;

class TermConditionService implements TermConditionServiceContract
{
    public function get(int $id)
    {
        return TermCondition::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $termConditionDb = new TermCondition();
            $termConditionDb->content     = Purifier::clean($request->content);
            $termConditionDb->created_by  = Sentinel::getUser()->name;
            $termConditionDb->save();

            DB::commit();

            return $termConditionDb;
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
            $termConditionDb = TermCondition::find($id);
            $termConditionDb->content     = Purifier::clean($request->content);
            $termConditionDb->updated_by  = Sentinel::getUser()->name;
            $termConditionDb->save();

            DB::commit();

            return $termConditionDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'term_condition.*',
        ];

        $dataDb = TermCondition::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('term_condition.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('term_condition.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
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
        $termConditionDb = TermCondition::where('id', $id)->first();
        $termConditionDb->deleted_by = Sentinel::getUser()->name;
        $termConditionDb->save();

        return TermCondition::where('id', $id)->delete();
    }

    public function destroyBulk(array $id)
    {
        return TermCondition::whereIn('id', $id)->delete();
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

            $count = TermCondition::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = TermCondition::select('id', 'content as text')->where('content', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
