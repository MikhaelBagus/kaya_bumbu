<?php

namespace App\Services\Source;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Source;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SourceService implements SourceServiceContract
{
    public function get(int $id)
    {
        return Source::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $sourceDb = new Source();
            $sourceDb->name          = $request->name;
            $sourceDb->created_by    = Sentinel::getUser()->email;
            $sourceDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$sourceDb->name;
            $logDb->menu        = 'Source';
            $logDb->item_id     = $sourceDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $sourceDb;
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
            $sourceDb = Source::find($id);
            $sourceDb->name          = $request->name;
            $sourceDb->updated_by    = Sentinel::getUser()->email;
            $sourceDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$sourceDb->name;
            $logDb->menu        = 'Source';
            $logDb->item_id     = $sourceDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $sourceDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'source.*',
        ];

        $dataDb = Source::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('source.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('source.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('source.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $sourceDb = Source::where('id', $id)->first();
        if(!$sourceDb->transaction->isEmpty()){
            return '';
        }
        else{
            $sourceDb->deleted_by = Sentinel::getUser()->email;
            $sourceDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$sourceDb->name;
            $logDb->menu        = 'Source';
            $logDb->item_id     = $sourceDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return Source::where('id', $id)->delete();
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

            $count = Source::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = Source::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
