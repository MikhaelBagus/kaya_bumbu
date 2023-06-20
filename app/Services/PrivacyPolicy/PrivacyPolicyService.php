<?php

namespace App\Services\PrivacyPolicy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\PrivacyPolicy;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Purifier;

class PrivacyPolicyService implements PrivacyPolicyServiceContract
{
    public function get(int $id)
    {
        return PrivacyPolicy::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $privacyPolicyDb = new PrivacyPolicy();
            $privacyPolicyDb->content     = Purifier::clean($request->content);
            $privacyPolicyDb->created_by  = Sentinel::getUser()->email;
            $privacyPolicyDb->save();

            DB::commit();

            return $privacyPolicyDb;
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
            $privacyPolicyDb = PrivacyPolicy::find($id);
            $privacyPolicyDb->content     = Purifier::clean($request->content);
            $privacyPolicyDb->updated_by  = Sentinel::getUser()->email;
            $privacyPolicyDb->save();

            DB::commit();

            return $privacyPolicyDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'privacy_policy.*',
        ];

        $dataDb = PrivacyPolicy::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('privacy_policy.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('privacy_policy.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
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
        $privacyPolicyDb = PrivacyPolicy::where('id', $id)->first();
        $privacyPolicyDb->deleted_by = Sentinel::getUser()->email;
        $privacyPolicyDb->save();

        return PrivacyPolicy::where('id', $id)->delete();
    }
}
