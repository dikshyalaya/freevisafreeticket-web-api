<?php

namespace App\Services;

class DateService
{
    public function calculateAgeFromDateOfBirth($date)
    {
        $today = date("Y-m-d");
        $diff = date_diff(date_create($date), date_create($today));
        return $diff->format('%y') != 0 ? $diff->format('%y') : '';
    }
}
