<?php

namespace App\Http\Controllers\Conversion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Conversion\ConverterRequest;
use App\Models\Conversion\ConversionValues\LengthConversionValues;
use App\Models\Conversion\ConversionValues\TypeMeasurement;
use App\Models\Conversion\ConversionValues\UnitConversionValues;
use App\Models\Conversion\ConversionValues\VolumeConversionValues;
use App\Models\Conversion\ConversionValues\WeightConversionValues;
use Exception;

class ConverterController extends Controller
{
    public function list_units(ConverterRequest $request)
    {
        try{
            $request->validated();
            $types = [
                'Longitud' => LengthConversionValues::$conversionValue,
                'Masa/Peso' => WeightConversionValues::$conversionValue,
                'Volumen' => VolumeConversionValues::$conversionValue,
                'Unidad' => UnitConversionValues::$conversionValue,
            ];
            return response()->json([
                'conversiones' => array_keys($types[$request->type]),
                'mensaje' => 'Lista de unidades de medidas para '.$request->type,
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la lista de unidades de medidas',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    public function list_types_measurements()
    {
        try{
            return response()->json([
                'conversiones' => TypeMeasurement::$typeMeasurement,
                'mensaje' => 'Lista de tipos de medidas',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la lista de unidades de medidas',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
