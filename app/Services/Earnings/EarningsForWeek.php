<?php

namespace App\Services\Earnings;

use App\Models\Sale;
use Carbon\Carbon;

class EarningsForWeek
{
    public function calculate()
    {
        $ventas = Sale::selectRaw('DAY(date), date, SUM(earning_total) as total')
            ->whereBetween('date', [
                now()->subDays(30)->startOfMonth(),
                now()->subDays(1)->endOfMonth()
            ])
            ->where('date', '>=', now()->subDays(30)->startOfMonth())
            ->where('organization_id', auth()->user()->organization_id)
            ->groupBy('date')
            ->get();

        $ventasFormateadas = [];

        foreach ($ventas as $venta){
            $total = number_format($venta->total, 2); // Formatea el total como número con dos decimales
            $ventasFormateadas[] = [
                'date' => $venta->date,
//                'day' => $day,
                'total' => $total
            ];
        }

        return $ventasFormateadas;
    }
}
