<?php

namespace App\Services\News;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\News;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Purifier;

class NewsService implements NewsServiceContract
{
    public function get(int $id)
    {
        return News::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            if($request->hasFile('image')){
                $file = $request->image;
                $file_path = $file->getPathName();

                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('media'), $filename);

                $filename = url('media/'.$filename);
            }
            else{
                $filename = '';
            }

            $newsDb = new News();
            $newsDb->title        = $request->title;
            $newsDb->content      = Purifier::clean($request->content);
            $newsDb->image        = $filename;
            $newsDb->publish      = $request->publish;
            $newsDb->created_by   = Sentinel::getUser()->email;
            $newsDb->save();

            DB::commit();

            return $newsDb;
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
            if($request->hasFile('image')){
                $file = $request->image;
                $file_path = $file->getPathName();

                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('media'), $filename);

                $filename = url('media/'.$filename);
            }
            else{
                $filename = '';
            }

            $newsDb = News::find($id);
            $newsDb->title        = $request->title;
            $newsDb->content      = Purifier::clean($request->content);
            $newsDb->publish      = $request->publish;

            if($filename != ''){
                $newsDb->image    = $filename;
            }
            else if($newsDb->old_image == null){
                $newsDb->image    = '';
            }

            $newsDb->updated_by   = Sentinel::getUser()->email;
            $newsDb->save();

            DB::commit();

            return $newsDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'news.*',
        ];

        $dataDb = News::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'image',
                function ($dataDb) {
                    if($dataDb->image == ''){
                        return '';
                    }
                    else{
                        return '<img src="'.$dataDb->image.'" height="100px">';
                    }
                }
            )
            ->addColumn(
                'publish',
                function ($dataDb) {
                    if($dataDb->publish){
                        return 'Yes';
                    }
                    else{
                        return 'No';
                    }
                }
            )
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="' . route('news.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a href="'.route('news.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->title]).'" data-href="'.route('news.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->rawColumns(array('content','image','action','publish'))
            ->make(true);
    }

    public function destroy(int $id)
    {
        $newsDb = News::where('id', $id)->first();
        $newsDb->deleted_by = Sentinel::getUser()->email;
        $newsDb->save();

        return News::where('id', $id)->delete();
    }
}
