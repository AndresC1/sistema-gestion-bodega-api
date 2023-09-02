<?php

namespace App\Models\Conversion\ConverterHandle;

use App\Models\Conversion\TypeConversion\VolumeConversionHandle;
use App\Models\Conversion\ConverterHandleInterface;

class ConverteHandle implements ConverterHandleInterface
{
    private $nextHandle;

    public function __construct()
    {
        $this->setNext();
    }

    public function setNext(): void
    {
        $this->nextHandle = new VolumeConversionHandle();
    }

    public function convert($amount, $from, $to)
    {
        return $this->nextHandle->convert($amount, $from, $to);
    }
}
