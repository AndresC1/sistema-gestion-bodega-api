<?php

namespace App\Models\Conversion\TypeConversion;

use App\Models\Conversion\ConversionValues\UnitConversionValues;
use App\Models\Conversion\ConverterHandleInterface;

class UnitConversionHandle implements ConverterHandleInterface
{
    private $nextHandle;
    private $conversionValue;

    public function __construct()
    {
        $this->setNext();
        $this->conversionValue = UnitConversionValues::$conversionValue;
    }

    public function setNext(): void
    {
        $this->nextHandle = null;
    }

    public function convert($amount, $from, $to)
    {
        if(isset($this->conversionValue[$from][$to])){
            return $amount * $this->conversionValue[$from][$to];
        } else {
            return null;
        }
    }
}
