<?php

namespace App\Models\Conversion;

interface ConverterHandleInterface
{
    public function setNext(): void;
    public function convert($amount, $from, $to);
}
