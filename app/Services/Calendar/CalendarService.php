<?php

namespace App\Services\Calendar;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Transaction;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CalendarService implements CalendarServiceContract
{
    public function get($month, $year)
    {
        $firstDate = $year.'-'.$month.'-01';
        $lastDay = date("t", strtotime($firstDate));

        $data = [];
        for ($date = 1; $date <= $lastDay; $date++) {
            $hourData = [];
            $countPerDay = 0;
            for ($hour = 0; $hour <= 23 ; $hour++) {
                if($date < 10){
                    if($hour < 10){
                        $dataTransaction = Transaction::where('date', $year.'-'.$month.'-0'.$date)->where(\DB::raw('substr(time, 1, 2)'), '=' , '0'.$hour)->get();
                        $countValue = 0;

                        if($dataTransaction->count() > 0){
                            foreach ($dataTransaction as $dataTransactionEach) {
                                foreach($dataTransactionEach->transaction_product as $transactionProductEach){
                                    $countValue = $countValue + ($transactionProductEach->qty * $transactionProductEach->product->value);
                                }
                            }
                        }

                        $countPerDay = $countPerDay + $countValue;

                        $hourData[] = [
                            'hour'  => '0'.$hour,
                            'count' => $countValue
                        ];
                    }
                    else{
                        $dataTransaction = Transaction::where('date', $year.'-'.$month.'-0'.$date)->where(\DB::raw('substr(time, 1, 2)'), '=' , ''.$hour)->get();
                        $countValue = 0;

                        if($dataTransaction->count() > 0){
                            foreach ($dataTransaction as $dataTransactionEach) {
                                foreach($dataTransactionEach->transaction_product as $transactionProductEach){
                                    $countValue = $countValue + ($transactionProductEach->qty * $transactionProductEach->product->value);
                                }
                            }
                        }

                        $countPerDay = $countPerDay + $countValue;

                        $hourData[] = [
                            'hour'  => ''.$hour,
                            'count' => $countValue
                        ];
                    }
                }
                else{
                    if($hour < 10){
                        $dataTransaction = Transaction::where('date', $year.'-'.$month.'-'.$date)->where(\DB::raw('substr(time, 1, 2)'), '=' , '0'.$hour)->get();
                        $countValue = 0;

                        if($dataTransaction->count() > 0){
                            foreach ($dataTransaction as $dataTransactionEach) {
                                foreach($dataTransactionEach->transaction_product as $transactionProductEach){
                                    $countValue = $countValue + ($transactionProductEach->qty * $transactionProductEach->product->value);
                                }
                            }
                        }

                        $countPerDay = $countPerDay + $countValue;

                        $hourData[] = [
                            'hour'  => '0'.$hour,
                            'count' => $countValue
                        ];
                    }
                    else{
                        $dataTransaction = Transaction::where('date', $year.'-'.$month.'-'.$date)->where(\DB::raw('substr(time, 1, 2)'), '=' , ''.$hour)->get();
                        $countValue = 0;

                        if($dataTransaction->count() > 0){
                            foreach ($dataTransaction as $dataTransactionEach) {
                                foreach($dataTransactionEach->transaction_product as $transactionProductEach){
                                    $countValue = $countValue + ($transactionProductEach->qty * $transactionProductEach->product->value);
                                }
                            }
                        }

                        $countPerDay = $countPerDay + $countValue;

                        $hourData[] = [
                            'hour'  => ''.$hour,
                            'count' => $countValue
                        ];
                    }
                }
            }

            if($date < 10){
                $data[] = [
                    'date' => $year.'-'.$month.'-0'.$date,
                    'hour' => $hourData,
                    'total'=> $countPerDay
                ];
            }
            else{
                $data[] = [
                    'date' => $year.'-'.$month.'-'.$date,
                    'hour' => $hourData,
                    'total'=> $countPerDay
                ];
            }
        }
        return $data;
    }

    public function getDetail($month, $year, $date, $hour)
    {
        $data = Transaction::where('date', $year.'-'.$month.'-'.$date)->where(\DB::raw('substr(time, 1, 2)'), '=' , $hour)->get();
        return $data;
    }
}
