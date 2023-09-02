<?php

namespace Tests\Unit\Converter;

use App\Models\Conversion\ConverterHandle\ConverteHandle;
use PHPUnit\Framework\TestCase;

class ConverterUnitTest extends TestCase
{
    public function test_converter_from_d_to_par(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'd', 'par');
        $this->assertEquals(6, $result);
    }

    public function test_converter_from_par_to_d(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(6, 'par', 'd');
        $this->assertEquals(1, round($result, 0));
    }

    public function test_converter_from_d_to_uni(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(2, 'd', 'uni');
        $this->assertEquals(24, $result);
    }

    public function test_converter_from_uni_to_d(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(24, 'uni', 'd');
        $this->assertEquals(2, round($result, 0));
    }

    public function test_converter_from_par_to_uni(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(2, 'par', 'uni');
        $this->assertEquals(4, $result);
    }

    public function test_converter_from_uni_to_par(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(4, 'uni', 'par');
        $this->assertEquals(2, $result);
    }

    public function test_converter_from_uni_to_uni(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'uni', 'uni');
        $this->assertEquals(1, $result);
    }
}
