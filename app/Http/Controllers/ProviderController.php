<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Provider;
use App\Http\Requests\Provider\StoreProviderRequest;
use App\Http\Requests\Provider\UpdateProviderRequest;
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
        try {
            $request->validated();
            $provider = Provider::create([
                'name' => $request['name'],
                'email' => $request['email']??null,
                'ruc' => $request['ruc'],
                'organization_id' => Auth::user()->organization->id,
                'municipality_id' => $request['municipality_id'],
                'city_id' => $request['city_id'],
                'contact_name' => $request['contact_name']??null,
                'address' => $request['address']??null,
                'phone_main' => $request['phone_main']??null,
                'phone_secondary' => $request['phone_secondary']??null,
                'details' => $request['details']??null,
                'status' => 'active',
            ]);
            $provider->save();
            return response()->json([
                'proveedor' => new ProviderCleanResource($provider),
                'mensaje' => 'Proveedor creado correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el proveedor',
                'error' => $e->getMessage(),
                'estado' => 400
            ], 400);
        }
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
        try {
            $request->validated();
            $provider->update([
                'name' => $request['name']??$provider->name,
                'email' => $request['email']??$provider->email,
                'ruc' => $request['ruc']??$provider->ruc,
                'municipality_id' => $request['municipality_id']??$provider->municipality_id,
                'city_id' => $request['city_id']??$provider->city_id,
                'contact_name' => $request['contact_name']??$provider->contact_name,
                'address' => $request['address']??$provider->address,
                'phone_main' => $request['phone_main']??$provider->phone_main,
                'phone_secondary' => $request['phone_secondary']??$provider->phone_secondary,
                'details' => $request['details']??$provider->details,
            ]);
            $provider->save();
            return response()->json([
                'proveedor' => new ProviderCleanResource($provider),
                'mensaje' => 'Proveedor actualizado correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el proveedor',
                'error' => $e->getMessage(),
                'estado' => 400
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        //
    }

    public function list_provider_by_organization(Organization $organization)
    {
        try {
            $providers = Provider::where('organization_id', $organization->id)->paginate(10);
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
                'mensaje' => 'Error al obtener los proveedores',
                'error' => $e->getMessage(),
                'estado' => 400
            ], 400);
        }
    }
    public function change_status(Provider $provider){
        try {
            $provider->status = $provider->status==="active"?"inactive":"active";
            $provider->save();
            return response()->json([
                'proveedor' => new ProviderCleanResource($provider),
                'mensaje' => 'Estado de proveedor actualizado correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar estado del proveedor',
                'error' => $e->getMessage(),
                'estado' => 400
            ], 400);
        }
    }
}
