<?php

namespace App\Services\Earnings;

use App\Models\Sale;
use Carbon\Carbon;

class EarningsForMonth
{
    public function calculate()
    {
        $ventas = Sale::selectRaw('YEAR(date) as year, MONTH(date) as mes, SUM(earning_total) as total')
            ->whereBetween('date', [
                now()->subMonths(12)->startOfMonth(),
                now()->subMonths(1)->endOfMonth()
            ])
            ->where('date', '>=', now()->subMonths(12)->startOfMonth())
            ->where('organization_id', auth()->user()->organization_id)
            ->groupBy('year', 'mes')
            ->get();

        $ventasFormateadas = [];

        foreach ($ventas as $venta) {
            $mes = Carbon::create()->month($venta->mes)->format('F');
            $year = $venta->year;
            $total = number_format($venta->total, 2); // Formatea el total como número con dos decimales
            $ventasFormateadas[] = [
                'mes' => $mes,
                'year' => $year,
                'total' => $total
            ];
        }

        return $ventasFormateadas;
    }
}
