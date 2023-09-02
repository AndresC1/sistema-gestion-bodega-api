<?php

namespace App\Models\Conversion\TypeConversion;


use App\Models\Conversion\ConversionValues\VolumeConversionValues;
use App\Models\Conversion\ConverterHandleInterface;
use App\Models\Conversion\TypeConversion\WeightConversionHandle;

class VolumeConversionHandle implements ConverterHandleInterface
{
    private $nextHandle;
    private $conversionValues;

    public function __construct()
    {
        $this->setNext();
        $this->conversionValues = VolumeConversionValues::$conversionValue;
    }

    public function setNext(): void
    {
        $this->nextHandle = new WeightConversionHandle();
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
