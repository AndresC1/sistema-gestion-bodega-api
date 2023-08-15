<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Provider\ProviderCleanResource;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $providers = Provider::where('organization_id', Auth::user()->organization->id)->paginate(10);
            return response()->json([
                'proveedores' => ProviderCleanResource::collection($providers),
                'meta' => [
                    'total' => $providers->total(),
                    'current_page' => $providers->currentPage(),
                    'per_page' => $providers->perPage(),
                    'last_page' => $providers->lastPage(),
                    'from' => $providers->firstItem(),
                    'to' => $providers->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $providers->previousPageUrl(),
                    'next_page_url' => $providers->nextPageUrl(),
                    'last_page_url' => $providers->url($providers->lastPage()),
                    'first_page_url' => $providers->url(1)
                ],
                'mensaje' => 'Proveedores obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los proveedores',
                'error' => $e->getMessage(),
                'estado' => 400
            ], 400);
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
    public function store(StoreProviderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        //
    }
}
