<?php

namespace App\Http\Controllers;

use App\Http\Resources\Client\ClientCleanResource;
use App\Models\Client;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Organization;
use Exception;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $organization_id = Auth::user()->organization->id;
            $clients = Client::where('organization_id', $organization_id)->paginate(10);
            return response()->json([
                'clients' => ClientCleanResource::collection($clients),
                'meta' => [
                    'total' => $clients->total(),
                    'current_page' => $clients->currentPage(),
                    'per_page' => $clients->perPage(),
                    'last_page' => $clients->lastPage(),
                    'from' => $clients->firstItem(),
                    'to' => $clients->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $clients->previousPageUrl(),
                    'next_page_url' => $clients->nextPageUrl(),
                    'last_page_url' => $clients->url($clients->lastPage()),
                    'first_page_url' => $clients->url(1)
                ],
                'message' => 'Clientes obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los clientes',
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
    public function store(StoreClientRequest $request)
    {
        try{
            $request->validated();
            $client = Client::create([
                'name' => $request->name,
                'address' => $request->address??null,
                'organization_id' => Auth::user()->organization->id,
                'municipality_id' => $request->municipality_id,
                'city_id' => $request->city_id,
                'type' => $request->type,
                'phone_main' => $request->phone_main??null,
                'phone_secondary' => $request->phone_secondary??null,
                'details' => $request->details??null,
                'status' => 'active',
            ]);
            $client->save();
            return response()->json([
                'cliente' => new ClientCleanResource($client),
                'mensaje' => 'Cliente creado correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el cliente',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        try{
            return response()->json([
                'cliente' => new ClientCleanResource($client),
                'mensaje' => 'Cliente obtenido correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener el cliente',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        try{
            $request->validated();
            $client->update($request->all());
            $client->save();
            return response()->json([
                'cliente' => new ClientCleanResource($client),
                'mensaje' => 'Cliente actualizado correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el cliente',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }

    public function list_clients_by_organization(Organization $organization){
        try{
            $clients = Client::where('organization_id', $organization->id)->paginate(10);
            return response()->json([
                'clientes' => ClientCleanResource::collection($clients),
                'meta' => [
                    'total' => $clients->total(),
                    'current_page' => $clients->currentPage(),
                    'per_page' => $clients->perPage(),
                    'last_page' => $clients->lastPage(),
                    'from' => $clients->firstItem(),
                    'to' => $clients->lastItem()
                ],
                'links' => [
                    'prev_page_url' => $clients->previousPageUrl(),
                    'next_page_url' => $clients->nextPageUrl(),
                    'last_page_url' => $clients->url($clients->lastPage()),
                    'first_page_url' => $clients->url(1)
                ],
                'mensaje' => 'Clientes obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los clientes',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function change_status(Client $client){
        try{
            $client->status = $client->status==="active"?"inactive":"active";
            $client->save();
            return response()->json([
                'cliente' => new ClientCleanResource($client),
                'mensaje' => 'Estado del cliente actualizado correctamente',
                'estado' => 201
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el estado del cliente',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
