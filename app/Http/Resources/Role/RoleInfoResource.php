<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\Permission\PermissionResource;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description'=> $this->description,
            'permissions' => $this->role_permission->map(function (RolePermission $role_permission) {
                return PermissionResource::make(Permission::find($role_permission->permission_id));
            })
        ];
    }
}
