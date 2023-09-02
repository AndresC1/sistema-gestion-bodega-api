<?php

namespace Tests\Unit\Converter;

use App\Models\Conversion\ConverterHandle\ConverteHandle;
use PHPUnit\Framework\TestCase;

class ConverterWeightTest extends TestCase
{
    public function test_converter_from_g_to_kg(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'g', 'kg');
        $this->assertEquals(0.001, $result);
    }

    public function test_converter_from_kg_to_g(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(10, 'kg', 'g');
        $this->assertEquals(10000, $result);
    }

    public function test_converter_from_kg_to_ton(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'kg', 'ton');
        $this->assertEquals(0.001, round($result, 3));
    }

    public function test_converter_from_g_to_lb(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(480, 'g', 'lb');
        $this->assertEquals(1.05822, round($result, 5));
    }

    public function test_converter_from_lb_to_g(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'lb', 'g');
        $this->assertEquals(453.592, $result);
    }
}
