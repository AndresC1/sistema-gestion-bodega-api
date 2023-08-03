<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\StoreOrganizationRequest as StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest as UpdateOrganizationRequest;
use App\Models\Organization;
use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return response()->json([
                'organizaciones' => OrganizationResource::collection(Organization::all()),
                'mensaje' => 'Organizaciones obtenidas correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener las organizaciones',
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
    public function store(StoreOrganizationRequest $request)
    {
        try{
            $organization = Organization::create($request->validated());
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización creada correctamente',
                'estado' => 201
            ], 201);
        }catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        try{
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización obtenida correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        try{
            $organization->update($request->validated());
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización actualizada correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        try{
            $organization->delete();
            return response()->json([
                'mensaje' => 'Organización eliminada correctamente',
                'estado' => 200
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function users_by_organization(Organization $organization){
        try{
            $users_by_organization = User::where('organization_id', $organization->id)->get();
            return response()->json([
                'usuarios' => UserResource::collection($users_by_organization),
                'mensaje' => 'Usuarios de organizacion obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los usuarios de la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function see_organization(){
        try{
            $organization = Organization::where('id', Auth::user()->organization_id)->first();
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización obtenida correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
    public function list_user(){
        try{
            $users = Auth::user()->organization->users->filter(function($user){
                return $user->id != Auth::user()->id;
            });
            return response()->json([
                'usuarios' => UserResource::collection($users),
                'mensaje' => 'Usuarios obtenidos correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener los usuarios',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
