<?php

namespace App\Services\ProductRanking;

interface ProductRankingServiceContract
{
    public function get($month, $year);

    public function getByDate($dateFrom, $dateTo);

    public function datatable($request);

    public function total($request);
}
