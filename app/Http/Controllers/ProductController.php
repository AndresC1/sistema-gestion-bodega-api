<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\ProductCleanResource;
use Exception;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $listProducts = Product::OrderBy('name')
                ->paginate(10);
            return response()->json([
                'products' => ProductCleanResource::collection($listProducts),
                'meta' => [
                    'total' => $listProducts->total(),
                    'current_page' => $listProducts->currentPage(),
                    'per_page' => $listProducts->perPage(),
                    'last_page' => $listProducts->lastPage(),
                    'from' => $listProducts->firstItem(),
                    'to' => $listProducts->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $listProducts->previousPageUrl(),
                    'next_page_url' => $listProducts->nextPageUrl(),
                    'last_page_url' => $listProducts->url($listProducts->lastPage()),
                    'first_page_url' => $listProducts->url(1)
                ],
                'mensaje' => 'Productos obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los productos',
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
    public function store(StoreProductRequest $request)
    {
        try{
            $product = Product::create($request->validated());
            return response()->json([
                'producto' => new ProductCleanResource($product),
                'mensaje' => 'Producto creado correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e){
            return response()->json([
                'mensaje' => 'Error al crear el producto',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try{
            return response()->json([
                'producto' => new ProductCleanResource($product)
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'mensaje' => 'Error al obtener el producto',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function search(string $name)
    {
        try{
            $products = Product::where('name', 'like', "%$name%")
                ->orWhere('id', 'like', "%$name%")
                ->get();
            return response()->json(ProductCleanResource::collection($products), 200);
        } catch(Exception $e){
            return response()->json([
                'mensaje' => 'Error al buscar el producto',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
