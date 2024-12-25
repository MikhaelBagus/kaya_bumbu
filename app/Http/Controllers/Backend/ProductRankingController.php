<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Services\ProductRanking\ProductRankingServiceContract;
use App\Traits\redirectTo;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Transaction;

class ProductRankingController extends Controller
{
    use redirectTo;

    public function index()
    {
        $transaction = Transaction::select('date')->orderBy('date','desc')->first();
        $date = new Carbon($transaction->date);
        $maxYear  = $date->year;
        $maxMonth = $date->month;
        $yearMin  = 2023;
        $monthMin = 6;

        $periode = [];
        for ($year = $yearMin; $year <= $maxYear; $year++) {
            if($year == $yearMin){
                for ($month = $monthMin; $month <= 12; $month++) {
                    $monthText = '';
                    if($month == 1){
                        $monthText = 'Januari';
                    } else if($month == 2){
                        $monthText = 'Februari';
                    } else if($month == 3){
                        $monthText = 'Maret';
                    } else if($month == 4){
                        $monthText = 'April';
                    } else if($month == 5){
                        $monthText = 'Mei';
                    } else if($month == 6){
                        $monthText = 'Juni';
                    } else if($month == 7){
                        $monthText = 'Juli';
                    } else if($month == 8){
                        $monthText = 'Agustus';
                    } else if($month == 9){
                        $monthText = 'September';
                    } else if($month == 10){
                        $monthText = 'Oktober';
                    } else if($month == 11){
                        $monthText = 'November';
                    } else if($month == 12){
                        $monthText = 'Desember';
                    }

                    $periode[] = [
                        'year'  => $year,
                        'month' => $month,
                        'monthText' => $monthText
                    ];
                }
            }
            else if($year == $maxYear){
                for ($month = 1; $month <= $maxMonth; $month++) {
                    $monthText = '';
                    if($month == 1){
                        $monthText = 'Januari';
                    } else if($month == 2){
                        $monthText = 'Februari';
                    } else if($month == 3){
                        $monthText = 'Maret';
                    } else if($month == 4){
                        $monthText = 'April';
                    } else if($month == 5){
                        $monthText = 'Mei';
                    } else if($month == 6){
                        $monthText = 'Juni';
                    } else if($month == 7){
                        $monthText = 'Juli';
                    } else if($month == 8){
                        $monthText = 'Agustus';
                    } else if($month == 9){
                        $monthText = 'September';
                    } else if($month == 10){
                        $monthText = 'Oktober';
                    } else if($month == 11){
                        $monthText = 'November';
                    } else if($month == 12){
                        $monthText = 'Desember';
                    }

                    $periode[] = [
                        'year'  => $year,
                        'month' => $month,
                        'monthText' => $monthText
                    ];
                }
            }
            else{
                for ($month = 1; $month <= 12; $month++) {
                    $monthText = '';
                    if($month == 1){
                        $monthText = 'Januari';
                    } else if($month == 2){
                        $monthText = 'Februari';
                    } else if($month == 3){
                        $monthText = 'Maret';
                    } else if($month == 4){
                        $monthText = 'April';
                    } else if($month == 5){
                        $monthText = 'Mei';
                    } else if($month == 6){
                        $monthText = 'Juni';
                    } else if($month == 7){
                        $monthText = 'Juli';
                    } else if($month == 8){
                        $monthText = 'Agustus';
                    } else if($month == 9){
                        $monthText = 'September';
                    } else if($month == 10){
                        $monthText = 'Oktober';
                    } else if($month == 11){
                        $monthText = 'November';
                    } else if($month == 12){
                        $monthText = 'Desember';
                    }

                    $periode[] = [
                        'year'  => $year,
                        'month' => $month,
                        'monthText' => $monthText
                    ];
                }
            }
        }

        $periode = array_reverse($periode);
        
        return view('backend.product_ranking.index', compact('periode'));
    }

    public function show($month, $year, ProductRankingServiceContract $productRankingServiceContract)
    {
        $date = new Carbon($year.'-'.$month.'-01');
        $nextMonth = $date->addMonth();
        $nextMonthText = $nextMonth->month;
        if($nextMonthText < 10){
            $nextMonthText = '0'.$nextMonthText;
        }
        else{
            $nextMonthText = ''.$nextMonthText;
        }
        $nextYearText  = $nextMonth->year;

        $date = new Carbon($year.'-'.$month.'-01');
        $prevMonth = $date->subMonth();
        $prevMonthText = $prevMonth->month;
        if($prevMonthText < 10){
            $prevMonthText = '0'.$prevMonthText;
        }
        else{
            $prevMonthText = ''.$prevMonthText;
        }
        $prevYearText  = $prevMonth->year;

        $product_ranking = $productRankingServiceContract->get($month, $year);
        if($month == '01'){
            $monthText = 'Januari';
        } else if($month == '02'){
            $monthText = 'Februari';
        } else if($month == '03'){
            $monthText = 'Maret';
        } else if($month == '04'){
            $monthText = 'April';
        } else if($month == '05'){
            $monthText = 'Mei';
        } else if($month == '06'){
            $monthText = 'Juni';
        } else if($month == '07'){
            $monthText = 'Juli';
        } else if($month == '08'){
            $monthText = 'Agustus';
        } else if($month == '09'){
            $monthText = 'September';
        } else if($month == '10'){
            $monthText = 'Oktober';
        } else if($month == '11'){
            $monthText = 'November';
        } else if($month == '12'){
            $monthText = 'Desember';
        }
        return view('backend.product_ranking.detail', compact('product_ranking','month','monthText','year','prevMonthText','prevYearText','nextMonthText','nextYearText'));
    }
}
