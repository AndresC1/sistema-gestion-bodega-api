<?php

namespace App\Http\Controllers;

use App\Exports\PurchaseExport;
use App\Exports\SheetsPurchase;
use App\Models\DetailsPurchase;
use App\Http\Requests\DetailsPurchase\ListDetailsPurchaseRequest;
use App\Http\Resources\DetailsPurchaseCleanResource;
use Exception;

class DetailsPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListDetailsPurchaseRequest $request)
    {
        try {
            $detailsPurchases = DetailsPurchase::where('product_id', $request->product_id)
                ->where('organization_id', auth()->user()->organization->id)
                ->paginate(10);
            return response()->json([
                'detalles_de_compra' => DetailsPurchaseCleanResource::collection($detailsPurchases),
                'meta' => [
                    'total' => $detailsPurchases->total(),
                    'current_page' => $detailsPurchases->currentPage(),
                    'per_page' => $detailsPurchases->perPage(),
                    'last_page' => $detailsPurchases->lastPage(),
                    'from' => $detailsPurchases->firstItem(),
                    'to' => $detailsPurchases->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $detailsPurchases->previousPageUrl(),
                    'next_page_url' => $detailsPurchases->nextPageUrl(),
                    'last_page_url' => $detailsPurchases->url($detailsPurchases->lastPage()),
                    'first_page_url' => $detailsPurchases->url(1)
                ],
                'mensaje' => 'Detalles de compra obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los detalles de la compra',
                'error' => $e->getMessage()
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
    public function store(StoreDetailsPurchaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailsPurchase $detailsPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailsPurchase $detailsPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailsPurchaseRequest $request, DetailsPurchase $detailsPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailsPurchase $detailsPurchase)
    {
        //
    }

   
}
