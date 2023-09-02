<?php

namespace App\Models\Conversion\TypeConversion;

use App\Models\Conversion\ConversionValues\WeightConversionValues;
use App\Models\Conversion\ConverterHandleInterface;
use App\Models\Conversion\TypeConversion\LengthConversionHandle;

class WeightConversionHandle implements ConverterHandleInterface
{
    private $nextHandle;
    private $conversionValues;

    public function __construct()
    {
        $this->setNext();
        $this->conversionValues = WeightConversionValues::$conversionValue;
    }

    public function setNext(): void
    {
        $this->nextHandle = new LengthConversionHandle();
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
