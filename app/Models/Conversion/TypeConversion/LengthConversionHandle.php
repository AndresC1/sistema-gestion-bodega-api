<?php

namespace App\Models\Conversion\TypeConversion;

use App\Models\Conversion\ConversionValues\LengthConversionValues;
use App\Models\Conversion\ConverterHandleInterface;
use App\Models\Conversion\TypeConversion\UnitConversionHandle;

class LengthConversionHandle implements ConverterHandleInterface
{
    private $nextHandle;
    private $conversionValues;

    public function __construct()
    {
        $this->setNext();
    }

    public function setNext(): void
    {
        $this->nextHandle = new UnitConversionHandle();
        $this->conversionValues = LengthConversionValues::$conversionValue;
    }

    public function convert($amount, $from, $to)
    {
        if(isset($this->conversionValues[$from][$to])){
            return $amount * $this->conversionValues[$from][$to];
        } else {
            return $this->nextHandle->convert($amount, $from, $to);
        }
    }
}
