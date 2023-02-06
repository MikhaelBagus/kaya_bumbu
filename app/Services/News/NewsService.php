<?php

namespace App\Services\News;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\News;
use App\Models\Notification;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;
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
                // $file = $request->image;

                // $filename = time().'.'.$file->getClientOriginalExtension();
                // $file->move(public_path('image'), $filename);

                // $filename = 'image/'.$filename;

                if (function_exists('curl_file_create')) { // php 5.5+
                    $cFile = curl_file_create($request->image);
                }
                else { // 
                    $cFile = '@' . realpath($request->image);
                }
                $post = array('image' => $cFile);

                $ch = curl_init ();
                curl_setopt ( $ch, CURLOPT_URL, 'http://api.ayonilai.com/api/media' );
                curl_setopt ( $ch, CURLOPT_POST, true );
                curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
                $result = curl_exec ( $ch );
                curl_close ( $ch );

                $json = json_decode($result);

                $filename = $json->data;
            }
            else{
                $filename = '';
            }

            $newsDb = new News();
            $newsDb->title        = $request->title;
            $newsDb->content      = Purifier::clean($request->content);
            $newsDb->image        = $filename;
            $newsDb->publish      = $request->publish;
            $newsDb->created_by   = Sentinel::getUser()->name;
            $newsDb->save();

            if($request->publish == 1){
                $notificationDb = new Notification();
                $notificationDb->user_id    = 1;
                $notificationDb->type       = 'News';
                $notificationDb->item_id    = $newsDb->id;
                $notificationDb->message    = $newsDb->title;
                $notificationDb->created_by = Sentinel::getUser()->name;
                $notificationDb->save();
            }

            DB::commit();

            if($request->publish == 1){
                $notification = [
                    'title' => 'Ayo Nilai',
                    'body'  => $newsDb->title,
                ];
                $data = [
                    'type'    => 'News',
                    'item_id' => (string) $newsDb->id,
                ];
                $url = 'https://fcm.googleapis.com/fcm/send';
                $fields = array(
                    'to'           => '/topics/Prospektus',
                    'notification' => $notification,
                    'data'         => $data
                );
                $fields = json_encode($fields);
                $headers = array(
                    'Authorization: key=AAAATp2hBPg:APA91bHBnPr5kVeTbpZ7yWzNHG7OQrhUuIVEOpOhIebG-ydUoj6mj48GmqB0V3ZmOoVcMFlbxDXox5meviWNgh4wd_R_mfpKNRlju90U_P55ZxPg1-xg1EzcdCWFYKTP-1TEYwvJ8TSm',
                    'Content-Type: application/json'
                );

                $ch = curl_init ();
                curl_setopt ( $ch, CURLOPT_URL, $url );
                curl_setopt ( $ch, CURLOPT_POST, true );
                curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

                $result = curl_exec ( $ch );
                // echo $result;
                curl_close ( $ch );
            }

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
                // $file = $request->image;

                // $filename = time().'.'.$file->getClientOriginalExtension();
                // $file->move(public_path('image'), $filename);

                // $filename = 'image/'.$filename;

                if (function_exists('curl_file_create')) { // php 5.5+
                    $cFile = curl_file_create($request->image);
                }
                else { // 
                    $cFile = '@' . realpath($request->image);
                }
                $post = array('image' => $cFile);

                $ch = curl_init ();
                curl_setopt ( $ch, CURLOPT_URL, 'http://api.ayonilai.com/api/media' );
                curl_setopt ( $ch, CURLOPT_POST, true );
                curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
                $result = curl_exec ( $ch );
                curl_close ( $ch );

                $json = json_decode($result);

                $filename = $json->data;
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

            $newsDb->updated_by   = Sentinel::getUser()->name;
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
        $newsDb->deleted_by = Sentinel::getUser()->name;
        $newsDb->save();

        return News::where('id', $id)->delete();
    }

    public function destroyBulk(array $id)
    {
        return News::whereIn('id', $id)->delete();
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

            $count = News::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = News::select('id', 'title as text', 'content')->where('publish',1)->where('title', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }
    }
}
