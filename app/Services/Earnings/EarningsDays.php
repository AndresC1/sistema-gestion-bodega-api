<?php

namespace App\Services\Earnings;

use App\Models\Sale;

class EarningsDays
{
    public function calculate()
    {
        $total = 0;
        $sales = 0;
        $listSales = Sale::where('organization_id', auth()->user()->organization_id)
            ->where('date', '>=', now('America/Managua')->subDays(1))
            ->get();
        foreach ($listSales as $sale) {
            $total += $sale->earning_total;
            $sales++;
        }
        return [
            'earnings_total' => $total,
            'sales_total' => $sales,
            'range' => [
                'start' => now('America/Managua')->format('d/m/Y'),
                'end' => now('America/Managua')->format('d/m/Y')
            ]
        ];
    }
}
