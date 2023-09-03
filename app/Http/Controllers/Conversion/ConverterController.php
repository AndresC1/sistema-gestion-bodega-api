<?php

namespace App\Http\Controllers\Conversion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Conversion\CheckConversionRequest;
use App\Http\Requests\Conversion\ConverterRequest;
use App\Models\Conversion\ConversionValues\LengthConversionValues;
use App\Models\Conversion\ConversionValues\TypeMeasurement;
use App\Models\Conversion\ConversionValues\UnitConversionValues;
use App\Models\Conversion\ConversionValues\VolumeConversionValues;
use App\Models\Conversion\ConversionValues\WeightConversionValues;
use App\Models\Conversion\ConverterHandle\ConverteHandle;
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

    public function converter(CheckConversionRequest $request){
        try{
            $request->validated();
            $conversion = new ConverteHandle();
            $amount = $request->amount;
            $from = $request->from;
            $to = $request->to;
            $result = $conversion->convert($amount, $from, $to);
            if($result == null){
                throw new Exception('No se puede realizar la conversión con las unidades de medida seleccionadas');
            }
            return response()->json([
                'from' => $from,
                'to' => $to,
                'resultado' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al realizar la conversión',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
