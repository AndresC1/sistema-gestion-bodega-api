<?php

namespace App\Http\Controllers;

use App\Http\Resources\Client\ClientCleanResource;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
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
        //
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
}
