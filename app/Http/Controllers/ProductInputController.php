<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntryProduct\EntryProductResource;
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
    public function show(ProductInput $productInput)
    {
        //
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
