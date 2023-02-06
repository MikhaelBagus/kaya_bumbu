<?php

namespace App\Services\ContactUs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\ContactUs;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Purifier;

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
            $contactUsDb->content     = Purifier::clean($request->content);
            $contactUsDb->created_by  = Sentinel::getUser()->name;
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
            $contactUsDb->content     = Purifier::clean($request->content);
            $contactUsDb->updated_by  = Sentinel::getUser()->name;
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
        $contactUsDb->deleted_by = Sentinel::getUser()->name;
        $contactUsDb->save();

        return ContactUs::where('id', $id)->delete();
    }

    public function destroyBulk(array $id)
    {
        return ContactUs::whereIn('id', $id)->delete();
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

            $count = ContactUs::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = ContactUs::select('id', 'content as text')->where('content', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
