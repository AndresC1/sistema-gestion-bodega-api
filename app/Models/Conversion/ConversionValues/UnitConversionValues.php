<?php

namespace App\Models\Conversion\ConversionValues;

class UnitConversionValues
{
    public static $conversionValue = [
        'uni' => [
            'uni' => 1,
            'd' => 0.0833333,
            'par' => 0.5,
            'md' => 0.1666,
        ],
        'd' => [
            'uni' => 12,
            'd' => 1,
            'par' => 6,
            'md' => 0.5,
        ],
        'par' => [
            'uni' => 2,
            'd' => 0.166667,
            'par' => 1,
            'md' => 0.3333,
        ],
        'md' =>[
            'md' => 1,
            'uni' => 12,
            'd' => 0.5,
            'par' => 3,
        ]
    ];
}
