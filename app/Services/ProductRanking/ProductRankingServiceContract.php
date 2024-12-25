<?php

namespace App\Services\ProductRanking;

interface ProductRankingServiceContract
{
    public function get($month, $year);
}
