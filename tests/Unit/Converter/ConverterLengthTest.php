<?php

namespace Tests\Unit\Converter;

use App\Models\Conversion\ConverterHandle\ConverteHandle;
use PHPUnit\Framework\TestCase;

class ConverterLengthTest extends TestCase
{
    public function test_converter_from_cm_to_in(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'cm', 'in');
        $this->assertEquals(0.393701, $result);
    }

    public function test_converter_from_in_to_cm(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'in', 'cm');
        $this->assertEquals(2.54, $result);
    }

    public function test_converter_from_m_to_ft(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'm', 'ft');
        $this->assertEquals(3.28084, $result);
    }

    public function test_converter_from_ft_to_m(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'ft', 'm');
        $this->assertEquals(0.3048, $result);
    }

    public function test_converter_from_m_to_yd(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'm', 'yd');
        $this->assertEquals(1.09361, $result);
    }

    public function test_converter_from_ft_to_dm(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(10, 'ft', 'dm');
        $this->assertEquals( 30.48, $result);
    }
}
