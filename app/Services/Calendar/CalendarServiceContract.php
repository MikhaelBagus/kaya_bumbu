<?php

namespace App\Services\Calendar;

interface CalendarServiceContract
{
    public function get($month, $year);

    public function getDetail($month, $year, $date, $hour);
}
