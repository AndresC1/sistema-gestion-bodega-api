<?php

namespace App\Http\Controllers;

use App\Exports\MultiplesSheet;
use App\Http\Requests\Inventory\SearchInventoryRequest;
use App\Http\Requests\Inventory\TypeInventoryRequest;
use App\Http\Resources\Inventory\DataMinStockResource;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Inventory\InventoryCleanResource;
use App\Http\Requests\Inventory\StoreInventoryRequest;
use App\Http\Resources\Inventory\InventoryResource;
use App\Http\Resources\Inventory\InfoProductResource;
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
            $filteredInventories = $inventory;
            $response = [
                'inventario' => InventoryCleanResource::collection($filteredInventories),
                'mensaje' => 'Inventario de '.$typeInventory.' obtenido correctamente',
                'estado' => 200
            ];
            if($request->is_available === "true"){
                $filteredInventories = $inventory->filter(function ($inventory) {
                    $inventory->productInputs = $inventory->productInputs->filter(function ($productInput) {
                        return $productInput->disponibility > 0;
                    });
                    return $inventory->productInputs->isNotEmpty();
                });
                $response['inventario'] = $filteredInventories;
            }else{
                $paginate_meta = [
                    'total' => $inventory->total(),
                    'current_page' => $inventory->currentPage(),
                    'per_page' => $inventory->perPage(),
                    'last_page' => $inventory->lastPage(),
                    'from' => $inventory->firstItem(),
                    'to' => $inventory->lastItem()
                ];
                $paginate_links = [
                    'prev_page_url' => $inventory->previousPageUrl() ? $inventory->previousPageUrl()."&type=".$request->type : null,
                    'next_page_url' => $inventory->nextPageUrl() ? $inventory->nextPageUrl()."&type=".$request->type : null,
                    'last_page_url' => $inventory->url($inventory->lastPage()) ? $inventory->url($inventory->lastPage())."&type=".$request->type : null,
                    'first_page_url' => $inventory->url(1) ? $inventory->url(1)."&type=".$request->type : null,
                ];
                array_push($response, $paginate_meta);
                array_push($response, $paginate_links);
            }

            return response()->json($response, 200);
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
                'stock' => 0,
                'stock_min' => $request->stock_min,
                'unit_of_measurement' => $request->unit_of_measurement,
                'location' => $request->location,
                'date_last_modified' => now('America/Managua'),
                'lot_number' => $request->lot_number,
                'note' => $request->note,
                'status' => $request->stock == 0 ? 'no disponible' : 'disponible',
                'total_value' => 0,
                'code' => $request->code,
                'description' => $request->description,
            ]);
            $inventory_product->save();
            return response()->json([
                'inventario' => new InventoryCleanResource($inventory_product),
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
        try{
            return response()->json([
                'inventario' => new InventoryResource($inventory),
                'mensaje' => 'Inventario obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el inventario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
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
            return response()->json([
                'inventario_stock_min' => DataMinStockResource::collection($product),
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

    public function search_for_product(SearchInventoryRequest $request){
        try {
            $request->validated();
            $product_search = Product::where('name', 'like', '%'.$request->product_name.'%')
                ->get();
            $product_id = $product_search->pluck('id');
            $inventory = Inventory::whereIn('product_id', $product_id)
                ->where('organization_id', auth()->user()->organization->id)
                ->where('type', $request->type)
                ->limit(10)
                ->get();
            return response()->json([
                'busqueda' => InventoryCleanResource::collection($inventory),
                'mensaje' => 'Busqueda de productos en el inventario obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al buscar producto en el inventario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    public function list_product_in_MP(){
        try{
            $inventory = Inventory::where('organization_id', auth()->user()->organization->id)
                ->where('type', 'MP')
                ->get();
            return response()->json([
                'inventario' => InfoProductResource::collection($inventory),
                'mensaje' => 'Inventario de productos obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el inventario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    public function list_product_in_PT(){
        try{
            $inventory = Inventory::where('organization_id', auth()->user()->organization->id)
                ->where('type', 'PT')
                ->get();
            return response()->json([
                'inventario' => InfoProductResource::collection($inventory),
                'mensaje' => 'Inventario de productos obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el inventario',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
