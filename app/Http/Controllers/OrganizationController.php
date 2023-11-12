<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\StoreOrganizationRequest as StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateMyOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest as UpdateOrganizationRequest;
use App\Http\Resources\User\UserCleanResource;
use App\Models\Organization;
use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $list_organization = Organization::paginate(10);
            return response()->json([
                'organizaciones' => OrganizationResource::collection($list_organization),
                'meta' => [
                    'total' => $list_organization->total(),
                    'current_page' => $list_organization->currentPage(),
                    'last_page' => $list_organization->lastPage(),
                    'per_page' => $list_organization->perPage(),
                ],
                'links' => [
                    'first' => $list_organization->url(1),
                    'last' => $list_organization->url($list_organization->lastPage()),
                    'prev' => $list_organization->previousPageUrl(),
                    'next' => $list_organization->nextPageUrl(),
                ],
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
            DB::beginTransaction();
            $organization = Organization::create($request->validated());
            if($request->hasFile('image')){
                $url_image = $request->file('image')->store('organizations/'.$organization->name.'/logo', 'public');
                $organization->image = FacadesRequest::root().'/public/storage/'.$url_image;
                $organization->save();
            }
            DB::commit();
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización creada correctamente',
                'estado' => 201
            ], 201);
        }catch(Exception $e) {
            DB::rollBack();
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
            DB::beginTransaction();
            $request->validated();
            if($request->hasFile('image')){
                $url_image = Storage::disk('public')->put('organizations/'.$organization->id.'/logo', $request->file('image'));
                $new_image = FacadesRequest::root().'/public/storage/'.$url_image;
                if(Storage::disk('public')->exists(str_replace(FacadesRequest::root().'/public/storage/', '', $organization->image))){
                    Storage::disk('public')->delete(str_replace(FacadesRequest::root().'/public/storage/', '', $organization->image));
                }
            }
            $organization->update([
                'name' => $request['name']??$organization->name,
                'ruc' => $request['ruc']??$organization->ruc,
                'address' => $request['address']??$organization->address,
                'sector_id' => $request['sector_id']??$organization->sector_id,
                'municipality_id' => $request['municipality_id']??$organization->municipality_id,
                'city_id' => $request['city_id']??$organization->city_id,
                'phone_main' => $request['phone_main']??$organization->phone_main,
                'phone_secondary' => $request['phone_secondary']??$organization->phone_secondary,
                'image' => $new_image??$organization->image,
            ]);
            DB::commit();
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización actualizada correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            DB::rollBack();
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
            $users_by_organization = User::where('organization_id', $organization->id)->paginate(10);
            return response()->json([
                'usuarios' => UserCleanResource::collection($users_by_organization),
                'meta' => [
                    'total' => $users_by_organization->total(),
                    'current_page' => $users_by_organization->currentPage(),
                    'last_page' => $users_by_organization->lastPage(),
                    'per_page' => $users_by_organization->perPage(),
                ],
                'links' => [
                    'first' => $users_by_organization->url(1),
                    'last' => $users_by_organization->url($users_by_organization->lastPage()),
                    'prev' => $users_by_organization->previousPageUrl(),
                    'next' => $users_by_organization->nextPageUrl(),
                ],
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
            $organization_id = Auth::user()->organization_id;
            $users = User::where('organization_id', $organization_id)->paginate(10);
            $usersFilter = $users->filter(function($user){
                return $user->id != Auth::user()->id;
            });
            return response()->json([
                'usuarios' => UserCleanResource::collection($usersFilter),
                'meta' => [
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                ],
                'links' => [
                    'first' => $users->url(1),
                    'last' => $users->url($users->lastPage()),
                    'prev' => $users->previousPageUrl(),
                    'next' => $users->nextPageUrl(),
                ],
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

    public function update_my_organization(UpdateMyOrganizationRequest $request){
        try{
            DB::beginTransaction();
            $request->validated();
            $organization = Organization::find(Auth::user()->organization_id);
            if($request->hasFile('image')){
                $url_image = Storage::disk('public')->put('organizations/'.$organization->id.'/logo', $request->file('image'));
                $new_image = FacadesRequest::root().'/public/storage/'.$url_image;
                if(Storage::disk('public')->exists(str_replace(FacadesRequest::root().'/public/storage/', '', $organization->image))){
                    Storage::disk('public')->delete(str_replace(FacadesRequest::root().'/public/storage/', '', $organization->image));
                }
            }
            $organization->update([
                'name' => $request['name']??$organization->name,
                'ruc' => $request['ruc']??$organization->ruc,
                'address' => $request['address']??$organization->address,
                'sector_id' => $request['sector_id']??$organization->sector_id,
                'municipality_id' => $request['municipality_id']??$organization->municipality_id,
                'city_id' => $request['city_id']??$organization->city_id,
                'phone_main' => $request['phone_main']??$organization->phone_main,
                'phone_secondary' => $request['phone_secondary']??$organization->phone_secondary,
                'image' => $new_image??$organization->image,
            ]);
            DB::commit();
            return response()->json([
                'organizacion' => new OrganizationResource($organization),
                'mensaje' => 'Organización actualizada correctamente',
                'estado' => 200
            ], 200);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json([
                'mensaje' => 'Error al actualizar la organización',
                'error' => $e->getMessage(),
                'estado' => 500
            ], 500);
        }
    }
}
