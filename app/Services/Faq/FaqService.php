<?php

namespace App\Services\Faq;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Faq;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class FaqService implements FaqServiceContract
{
    public function get(int $id)
    {
        return Faq::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $faqDb = new Faq();
            $faqDb->question    = $request->question;
            $faqDb->answer      = $request->answer;
            $faqDb->created_by  = Sentinel::getUser()->email;
            $faqDb->save();

            DB::commit();

            return $faqDb;
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
            $faqDb = Faq::find($id);
            $faqDb->question    = $request->question;
            $faqDb->answer      = $request->answer;
            $faqDb->updated_by  = Sentinel::getUser()->email;
            $faqDb->save();

            DB::commit();

            return $faqDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'faq.*',
        ];

        $dataDb = Faq::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('faq.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('faq.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->question]).'" data-href="'.route('faq.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $faqDb = Faq::where('id', $id)->first();
        $faqDb->deleted_by = Sentinel::getUser()->email;
        $faqDb->save();

        return Faq::where('id', $id)->delete();
    }
}
