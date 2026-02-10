<?php

namespace App\Services\PaymentMethod;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\PaymentMethod;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class PaymentMethodService implements PaymentMethodServiceContract
{
    public function get(int $id)
    {
        return PaymentMethod::find($id);
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $paymentMethodDb = new PaymentMethod();
            $paymentMethodDb->name          = $request->name;
            $paymentMethodDb->created_by    = Sentinel::getUser()->email;
            $paymentMethodDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Create '.$paymentMethodDb->name;
            $logDb->menu        = 'Payment Method';
            $logDb->item_id     = $paymentMethodDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $paymentMethodDb;
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
            $paymentMethodDb = PaymentMethod::find($id);
            $paymentMethodDb->name          = $request->name;
            $paymentMethodDb->updated_by    = Sentinel::getUser()->email;
            $paymentMethodDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Update '.$paymentMethodDb->name;
            $logDb->menu        = 'Payment Method';
            $logDb->item_id     = $paymentMethodDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            DB::commit();

            return $paymentMethodDb;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function datatable($request)
    {
        $select = [
            'payment_method.*',
        ];

        $dataDb = PaymentMethod::select($select);

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('payment_method.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('payment_method.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('payment_method.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
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
        $paymentMethodDb = PaymentMethod::where('id', $id)->first();
        if(!$paymentMethodDb->purchase->isEmpty()){
            return '';
        }
        else{
            $paymentMethodDb->deleted_by = Sentinel::getUser()->email;
            $paymentMethodDb->save();

            $logDb = new Log();
            $logDb->user_id     = Sentinel::getUser()->id;
            $logDb->action      = 'Delete '.$paymentMethodDb->name;
            $logDb->menu        = 'Payment Method';
            $logDb->item_id     = $paymentMethodDb->id;
            $logDb->created_by  = Sentinel::getUser()->email;
            $logDb->save();

            return PaymentMethod::where('id', $id)->delete();
        }
    }

    public function select2($request)
    {
        try {
            $perPage = 10;
            $page    = $request->page ?? 1;

            // Handle search term from either 'term' or 'search.term'
            $term = '';
            if ($request->has('term')) {
                $term = $request->term;
            } elseif ($request->has('search') && is_array($request->search) && isset($request->search['term'])) {
                $term = $request->search['term'];
            }

            Paginator::currentPageResolver(
                function () use ($page) {
                    return $page;
                }
            );

            $count = PaymentMethod::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = PaymentMethod::select('id', DB::raw('name as text'))
                ->where('name', 'LIKE', '%'.$term.'%')
                ->orderBy('text')
                ->paginate($perPage);

            // Convert to Select2 format
            return response()->json([
                'results' => $dataDb->items(),
                'pagination' => [
                    'more' => $dataDb->hasMorePages()
                ]
            ]);
        }
        catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
