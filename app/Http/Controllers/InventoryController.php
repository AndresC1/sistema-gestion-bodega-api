<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\TypeInventoryRequest;
use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Http\Resources\Inventory\InventoryCleanResource;
use Exception;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TypeInventoryRequest $request)
    {
        try{
            $request->validated();
            $typeInventory = $request->type === 'MP' ? 'Materia Prima' : 'Producto Terminado';
            $inventory = Inventory::where('type', $request->type)
                ->where('organization_id', auth()->user()->organization->id)
                ->paginate(10);
            return response()->json([
                'inventario' => InventoryCleanResource::collection($inventory),
                'meta' => [
                    'total' => $inventory->total(),
                    'current_page' => $inventory->currentPage(),
                    'per_page' => $inventory->perPage(),
                    'last_page' => $inventory->lastPage(),
                    'from' => $inventory->firstItem(),
                    'to' => $inventory->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $inventory->previousPageUrl(),
                    'next_page_url' => $inventory->nextPageUrl(),
                    'last_page_url' => $inventory->url($inventory->lastPage()),
                    'first_page_url' => $inventory->url(1)
                ],
                'mensaje' => 'Inventario de '.$typeInventory.' obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el inventario',
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
    public function store(StoreInventoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
