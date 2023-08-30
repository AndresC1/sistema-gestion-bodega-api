<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductInput\ShowInventoryRequest;
use App\Http\Resources\EntryProduct\EntryProductResource;
use App\Models\Inventory;
use App\Models\ProductInput;
use App\Http\Requests\ProductInput\StoreProductInputRequest;
use App\Services\EntryProductService;
use Exception;

class ProductInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreProductInputRequest $request, EntryProductService $entryProductService)
    {
        try{
            $validate = $entryProductService->Validate($request->json()->all());
            if($validate != null){
                return response()->json([
                    'message' => 'Error al validar datos',
                    'error' => $validate,
                    'estado' => 422
                ], 422);
            }
            $request->validated();

            $productInput = $entryProductService->insertProductInput($request, $request->json()->all());

            return response()->json([
                'productInput' => EntryProductResource::make(ProductInput::find($productInput)),
                'mensaje' => 'Producto terminado registrado correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e){
            return response()->json([
                'mensaje' => 'Error al registrar el producto terminado',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowInventoryRequest $request)
    {
        try{
            $productInputs = Inventory::find($request->inventory_id)->productInputs()->paginate(10);
            return response()->json([
                'entradas' => EntryProductResource::collection($productInputs),
                'meta' => [
                    'total' => $productInputs->total(),
                    'current_page' => $productInputs->currentPage(),
                    'per_page' => $productInputs->perPage(),
                    'last_page' => $productInputs->lastPage(),
                    'from' => $productInputs->firstItem(),
                    'to' => $productInputs->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $productInputs->previousPageUrl(),
                    'next_page_url' => $productInputs->nextPageUrl(),
                    'last_page_url' => $productInputs->url($productInputs->lastPage()),
                    'first_page_url' => $productInputs->url(1)
                ],
                'mensaje' => 'Entradas obtenidas correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'mensaje' => 'Error al obtener las entradas',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductInput $productInput)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductInputRequest $request, ProductInput $productInput)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductInput $productInput)
    {
        //
    }
}
