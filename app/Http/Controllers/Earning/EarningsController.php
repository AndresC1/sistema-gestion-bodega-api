<?php

namespace App\Http\Controllers\Earning;

use App\Http\Controllers\Controller;
use App\Services\Earnings\CalculateEarnings;
use App\Services\Earnings\EarningsDays;
use Illuminate\Http\Request;
use Mockery\Exception;

class EarningsController extends Controller
{
    public function short_term_profits(){
        try {
            $calculateEarnings = new CalculateEarnings();
            $earnings = $calculateEarnings->calculateEarnings();
            $earnings_today = $earnings['today'];
            $earnings_last_week = $earnings['last_week'];
            $earnings_last_month = $earnings['last_month'];
            return response()->json([
                'today' => [
                    'earnings_total' => $earnings_today['earnings_total'],
                    'sales_total' => $earnings_today['sales_total'],
                    'range' => [
                        'start' => $earnings_today['range']['start'],
                        'end' => $earnings_today['range']['end']
                    ]
                ],
                'last_week' => [
                    'earnings_total' => $earnings_last_week['earnings_total'],
                    'sales_total' => $earnings_last_week['sales_total'],
                    'range' => [
                        'start' => $earnings_last_week['range']['start'],
                        'end' => $earnings_last_week['range']['end']
                    ]
                ],
                'last_month' => [
                    'earnings_total' => $earnings_last_month['earnings_total'],
                    'sales_total' => $earnings_last_month['sales_total'],
                    'range' => [
                        'start' => $earnings_last_month['range']['start'],
                        'end' => $earnings_last_month['range']['end']
                    ]
                ],
                'mensaje' => 'Datos obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los datos',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
