<?php

namespace App\Http\Controllers;

use App\Exports\SheetsPurchase;
use App\Models\Purchase;
use Exception;
use App\Http\Resources\Purchase\PurchaseCleanResource;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Services\DetailsPurchaseService;
use App\Services\PurchaseService;
use Illuminate\Support\Facades\DB;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $purchases = Purchase::where('organization_id', auth()->user()->organization_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return response()->json([
                'purchases' => PurchaseCleanResource::collection($purchases),
                'meta' => [
                    'total' => $purchases->total(),
                    'currentPage' => $purchases->currentPage(),
                    'perPage' => $purchases->perPage(),
                    'lastPage' => $purchases->lastPage(),
                    'firstItem' => $purchases->firstItem(),
                    'lastItem' => $purchases->lastItem(),
                ],
                'links' => [
                    'first' => $purchases->url(1),
                    'last' => $purchases->url($purchases->lastPage()),
                    'prev' => $purchases->previousPageUrl(),
                    'next' => $purchases->nextPageUrl(),
                ],
                'message' => 'Lista de compras',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las compras',
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
    public function store(StorePurchaseRequest $request)
    {
        try{
            DB::beginTransaction();
            $request->validated();
            $purchase_service = new PurchaseService();
            $validate = $purchase_service->validate_details_purchase($request->json()->all());
            if($validate != null){
                return response()->json([
                    'message' => 'Error al crear la compra',
                    'error' => $validate,
                    'estado' => 422
                ], 422);
            }
            $purchase_new = $purchase_service->register($request);
            DB::commit();
            return response()->json([
                'purchase' => new PurchaseCleanResource($purchase_new),
                'message' => 'Compra creada correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la compra',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }


}
