<?php

namespace App\Http\Controllers;

use App\Exports\SheetsSales;
use App\Http\Resources\Sale\SaleCleanResource;
use App\Models\Sale;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Exception;
use http\Env\Response;
use Illuminate\Support\Facades\DB;
use App\Services\SaleService;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $sales = Sale::where('organization_id', auth()->user()->organization_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return response()->json([
                'sales' => SaleCleanResource::collection($sales),
                'meta' => [
                    'total' => $sales->total(),
                    'currentPage' => $sales->currentPage(),
                    'perPage' => $sales->perPage(),
                    'lastPage' => $sales->lastPage(),
                    'firstItem' => $sales->firstItem(),
                    'lastItem' => $sales->lastItem(),
                ],
                'links' => [
                    'first' => $sales->url(1),
                    'last' => $sales->url($sales->lastPage()),
                    'prev' => $sales->previousPageUrl(),
                    'next' => $sales->nextPageUrl(),
                ],
                'message' => 'Lista de ventas',
                'estado' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las ventas',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        try{
            DB::beginTransaction();
            $saleService = new SaleService();
            $validate = $saleService->validate($request->json()->all());
            if($validate != null){
                return response()->json([
                    'message' => 'Error al registrar la venta',
                    'error' => $validate,
                    'estado' => 422
                ], 422);
            }
            $dataSale = $saleService->create($request->all(), $request->json()->all());
            DB::commit();
            return response()->json([
                'venta' => new SaleCleanResource($dataSale),
                'mensaje' => 'Venta registrada correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la venta',
                'error' => $e->getMessage(),
                'estado' => 400
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

}
