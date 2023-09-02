<?php

namespace App\Models\Conversion\ConversionValues;

class VolumeConversionValues
{
    public static $conversionValue = [
        'l' => [
            'gl' => 0.264172,
            'ml' => 1000,
            'cl' => 100,
            'dl' => 10,
            'l' => 1,
        ],
        'ml' => [
            'gl' => 0.000264172,
            'ml' => 1,
            'cl' => 0.1,
            'dl' => 0.01,
            'l' => 0.001,
        ],
        'cl' => [
            'gl' => 0.00264172,
            'ml' => 10,
            'cl' => 1,
            'dl' => 0.1,
            'l' => 0.01,
        ],
        'dl' => [
            'gl' => 0.0264172,
            'ml' => 100,
            'cl' => 10,
            'dl' => 1,
            'l' => 0.1,
        ],
        'gl' => [
            'gl' => 1,
            'ml' => 3785.41,
            'cl' => 378.541,
            'dl' => 37.8541,
            'l' => 3.78541,
        ]
    ];
}
