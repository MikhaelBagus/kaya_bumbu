<?php

namespace App\Services\Calendar;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class CalendarService implements CalendarServiceContract
{
    public function get($month, $year)
    {
        $firstDate = $year.'-'.$month.'-01';
        $lastDay = date("t", strtotime($firstDate));

        $formattedMonth = $month < 10 ? '0'.$month : ''.$month;
        $startDate = $year.'-'.$formattedMonth.'-01';
        $endDate = $year.'-'.$formattedMonth.'-'.($lastDay < 10 ? '0'.$lastDay : ''.$lastDay);

        $transactions = Transaction::with(['transaction_product.product'])
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy(function($transaction) {
                return $transaction->date . '_' . substr($transaction->time, 0, 2);
            });

        $data = [];
        for ($date = 1; $date <= $lastDay; $date++) {
            $hourData = [];
            $countPerDay = 0;
            
            $formattedDate = $date < 10 ? 
                $year.'-'.$month.'-0'.$date : 
                $year.'-'.$month.'-'.$date;
            
            for ($hour = 0; $hour <= 23; $hour++) {
                $formattedHour = $hour < 10 ? '0'.$hour : ''.$hour;
                
                $lookupDate = $date < 10 ? 
                    $year.'-'.$formattedMonth.'-0'.$date : 
                    $year.'-'.$formattedMonth.'-'.$date;
                $lookupHour = $hour < 10 ? '0'.$hour : ''.$hour;
                $key = $lookupDate . '_' . $lookupHour;
                
                $countValue = 0;
                if (isset($transactions[$key])) {
                    foreach ($transactions[$key] as $dataTransactionEach) {
                        foreach($dataTransactionEach->transaction_product as $transactionProductEach){
                            $countValue = $countValue + ($transactionProductEach->qty * $transactionProductEach->product->value);
                        }
                    }
                }

                $countPerDay = $countPerDay + $countValue;

                $hourData[] = [
                    'hour'  => $formattedHour,
                    'count' => $countValue
                ];
            }

            $data[] = [
                'date' => $formattedDate,
                'hour' => $hourData,
                'total'=> $countPerDay
            ];
        }
        return $data;
    }

    public function getDetail($month, $year, $date, $hour)
    {
        $data = Transaction::where('date', $year.'-'.$month.'-'.$date)->where(DB::raw('substr(time, 1, 2)'), '=' , $hour)->get();
        return $data;
    }
}
