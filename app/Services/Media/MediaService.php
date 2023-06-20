<?php

namespace App\Services\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Media;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class MediaService implements MediaServiceContract
{
    public function get(int $id)
    {
        return Media::find($id);
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

            $mediaDb = new Media();
            $mediaDb->type         = $request->type;
            $mediaDb->url          = $filename;
            $mediaDb->created_by   = Sentinel::getUser()->email;
            $mediaDb->save();

            DB::commit();

            return $mediaDb;
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

            $mediaDb = Media::find($id);
            $mediaDb->type       = $request->type;

            if($filename != ''){
                $mediaDb->url    = $filename;
            }
            else if($mediaDb->old_image == null){
                $mediaDb->url    = '';
            }

            $mediaDb->updated_by = Sentinel::getUser()->email;
            $mediaDb->save();

            DB::commit();

            return $mediaDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'media.*',
        ];

        $dataDb = Media::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'url',
                function ($dataDb) {
                    if($dataDb->url == ''){
                        return '';
                    }
                    else{
                        return '<a href="'.$dataDb->url.'" target="_blank"/>'.$dataDb->url.'</a>';
                    }
                }
            )
            ->addColumn(
                'view',
                function ($dataDb) {
                    if($dataDb->type == 'image'){
                        if($dataDb->url == ''){
                            return '';
                        }
                        else{
                            return '<img src="'.$dataDb->url.'" height="100px">';
                        }
                    }
                }
            )
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a href="#" onClick="copyToClipboard(\''.$dataDb->url.'\')" id="tooltip" data-title="Copy Url To ClipBoard"><span class="label label-default label-sm"><i class="fa fa-clipboard"></i></span></a>
                    <a href="' . route('media.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>';
                        // '<a href="'.route('media.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
                        // '<a href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->type]).'" data-href="'.route('media.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->rawColumns(array('view','url','action'))
            ->make(true);
    }

    public function destroy(int $id)
    {
        $mediaDb = Media::where('id', $id)->first();
        $mediaDb->deleted_by = Sentinel::getUser()->email;
        $mediaDb->save();

        return Media::where('id', $id)->delete();
    }
}
