<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CurrencyController extends Controller
{
    public function select2(Request $request)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {
                $page = $request->page ?? 1;
                $pageSize = 10;

                $query = Currency::select('id', 'code', 'name', 'symbol')
                    ->where('is_active', true)
                    ->orderBy('code', 'asc');

                if ($request->has('search') && $request->search['term'] != '') {
                    $query->where(function($q) use ($request) {
                        $q->where('code', 'like', '%' . $request->search['term'] . '%')
                          ->orWhere('name', 'like', '%' . $request->search['term'] . '%');
                    });
                }

                $data = $query->paginate($pageSize, ['*'], 'page', $page);

                $results = [];
                foreach ($data as $item) {
                    $results[] = [
                        'id' => $item->id,
                        'text' => $item->code . ' - ' . $item->name,
                    ];
                }

                return response()->json([
                    'results' => $results,
                    'pagination' => [
                        'more' => $data->hasMorePages()
                    ]
                ]);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }

    public function getAll(Request $request)
    {
        if(Sentinel::getUser()){
            if ($request->ajax() === true) {
                $currencies = Currency::where('is_active', true)
                    ->orderBy('code', 'asc')
                    ->get(['id', 'code', 'name', 'symbol']);

                return response()->json($currencies);
            }

            return abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
