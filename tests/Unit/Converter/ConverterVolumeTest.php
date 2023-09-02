<?php

namespace Tests\Unit\Converter;

use PHPUnit\Framework\TestCase;
use App\Models\Conversion\ConverterHandle\ConverteHandle;

class ConverterVolumeTest extends TestCase
{
    public function test_converter_from_l_to_ml(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1, 'l', 'ml');
        $this->assertEquals(1000, $result);
    }

    public function test_converter_from_ml_to_l(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(1000, 'ml', 'l');
        $this->assertEquals(1, $result);
    }

    public function test_converter_from_gl_to_ml(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(25, 'gl', 'ml');
        $this->assertEquals(94635.25, $result);
    }

    public function test_converter_from_ml_to_gl(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(94635.25, 'ml', 'gl');
        $this->assertEquals(25, round($result, 0));
    }

    public function test_converter_data_not_found(): void
    {
        $converter = new ConverteHandle();
        $result = $converter->convert(25, 'xx', 'zz');
        $this->assertEquals(null, $result);
    }
}
