<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\TypeInventoryRequest;
use App\Http\Resources\Inventory\DataMinStockResource;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Inventory\InventoryCleanResource;
use App\Http\Requests\Inventory\StoreInventoryRequest;
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
        try{
            $request->validated();
            $inventory_product = Inventory::create([
                'product_id' => $request->product_id,
                'organization_id' => auth()->user()->organization->id,
                'type' => $request->type,
                'stock' => $request->stock,
                'stock_min' => $request->stock_min,
                'unit_of_measurement' => $request->unit_of_measurement,
                'location' => $request->location,
                'date_last_modified' => now('America/Managua'),
                'lot_number' => $request->lot_number,
                'note' => $request->note,
                'status' => $request->stock == 0 ? 'no disponible' : 'disponible',
                'total_value' => $request->total_value,
                'code' => $request->code,
                'description' => $request->description,
            ]);
            $inventory_product->save();
            return response()->json([
                'mensaje' => 'Producto registrado al inventario correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al registrar producto al inventario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
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

    public function list_min_stock(){
        try{
            $product = Inventory::where('organization_id', auth()->user()->organization->id)
                ->where('stock', '<=', DB::raw('stock_min'))
                ->get();
            $finished_product = $product->where('type', 'PT');
            $raw_material = $product->where('type', 'MP');
            return response()->json([
                'productos_terminados' => DataMinStockResource::collection($finished_product),
                'materia_prima' => DataMinStockResource::collection($raw_material),
                'mensaje' => 'Inventario de productos con stock minimo obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener lista de productos con stock minimo',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
