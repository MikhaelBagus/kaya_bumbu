<?php

namespace App\Services\ContactUs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\ContactUs;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ContactUsService implements ContactUsServiceContract
{
    public function get(int $id)
    {
        return ContactUs::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $contactUsDb = new ContactUs();
            $contactUsDb->content     = $request->content;
            $contactUsDb->created_by  = Sentinel::getUser()->email;
            $contactUsDb->save();

            DB::commit();

            return $contactUsDb;
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
            $contactUsDb = ContactUs::find($id);
            $contactUsDb->content     = $request->content;
            $contactUsDb->updated_by  = Sentinel::getUser()->email;
            $contactUsDb->save();

            DB::commit();

            return $contactUsDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'contact_us.*',
        ];

        $dataDb = ContactUs::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('contact_us.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('contact_us.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
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
        $contactUsDb = ContactUs::where('id', $id)->first();
        $contactUsDb->deleted_by = Sentinel::getUser()->email;
        $contactUsDb->save();

        return ContactUs::where('id', $id)->delete();
    }
}
