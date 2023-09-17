<?php

namespace App\Services\Earnings;

class CalculateEarnings
{
    public function calculateEarnings(){
        $today = new EarningsDays();
        $last_week = new EarningsLastWeek();
        $last_month = new EarningsMonth();

        $today = $today->calculate();
        $last_week = $last_week->calculate();
        $last_month = $last_month->calculate();

        return [
            'today' => $today,
            'last_week' => $last_week,
            'last_month' => $last_month
        ];
    }
}
