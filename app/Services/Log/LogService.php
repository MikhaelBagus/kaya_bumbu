<?php

namespace App\Services\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class LogService implements LogServiceContract
{
    public function datatable($request)
    {
        $select = [
            'log.*',
        ];

        $dataDb = Log::select($select)->with('user');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->make(true);
    }
}
