<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\StoreOrganizationRequest as StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest as UpdateOrganizationRequest;
use App\Models\Organization;
use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

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
            $request->validated();
            $organization->update([
                'name' => $request['name']??$organization->name,
                'ruc' => $request['ruc']??$organization->ruc,
                'address' => $request['address']??$organization->address,
                'sector_id' => $request['sector_id']??$organization->sector_id,
                'municipality_id' => $request['municipality_id']??$organization->municipality_id,
                'city_id' => $request['city_id']??$organization->city_id,
                'phone_main' => $request['phone_main']??$organization->phone_main,
                'phone_secondary' => $request['phone_secondary']??$organization->phone_secondary,
            ]);
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

    public function update_my_organization(Request $request){
        try{
            $organization = Organization::find(Auth::user()->organization_id);
            $validacion = new UpdateOrganizationRequest($organization);
            $request->validate($validacion->rules(), $validacion->messages());
            $organization->update([
                'name' => $request->name??$organization->name,
                'ruc' => $request->ruc??$organization->ruc,
                'address' => $request->address??$organization->address,
                'sector_id' => $request->sector_id??$organization->sector_id,
                'municipality_id' => $request->municipality_id??$organization->municipality_id,
                'city_id' => $request->city_id??$organization->city_id,
                'phone_main' => $request->phone_main??$organization->phone_main,
                'phone_secondary' => $request->phone_secondary??$organization->phone_secondary,
            ]);
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización obtenida correctamente',
                'estado' => 200
            ], 200);
            $organization->update([
                'name' => $request->name??$organization->name,
                'ruc' => $request->ruc??$organization->ruc,
                'address' => $request->address??$organization->address,
                'sector_id' => $request->sector_id??$organization->sector_id,
                'municipality_id' => $request->municipality_id??$organization->municipality_id,
                'city_id' => $request->city_id??$organization->city_id,
                'phone_main' => $request->phone_main??$organization->phone_main,
                'phone_secondary' => $request->phone_secondary??$organization->phone_secondary,
            ]);
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización obtenida correctamente',
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
}
