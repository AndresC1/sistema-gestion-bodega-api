<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Location\CityController as LocationCityController;
use App\Http\Controllers\Location\MunicipalityController as LocationMunicipalityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Autenticación
    Route::post('/auth/login', [AuthController::class, "login"])->middleware('check_status_user');
    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, "logout"]);
        Route::middleware('check_permission:add_user')->group(function () {
            Route::post('/auth/register', [AuthController::class, "register"]);
        });
        
        // Usuarios
            // Informacion de usuario
        Route::get('/user/info', [UserController::class, "show"]);
        // Actualizacion de datos para usuario
        Route::middleware('check_permission:update_data_user')->group(function () {
            Route::patch('/user/{user}', [UserController::class, "update"]);
        });
            // Cambio de estado para usuario
        Route::middleware('check_permission:change_status_by_user')->group(function () {
            Route::get('/user/{user}/change_status', [UserController::class, "change_status"]);
        });
            // Lista de usuarios del sistema
        Route::middleware('check_permission:view_list_user')->group(function () {
            Route::get('/users', [UserController::class, "index"]);
        });

        // Sectores
        Route::middleware('check_permission:view_list_sector')->group(function () {
            Route::get('/sectors', [SectorController::class, "index"]);
        });
        Route::middleware('check_permission:view_list_organization_by_sector')->group(function () {
            Route::get('/sector/{sector}/organizations', [SectorController::class, "organization_for_sector"]);
        });

        // Organizaciones
        Route::middleware('check_permission:view_list_organization')->group(function () {
            Route::get('/organizations', [OrganizationController::class, "index"]);
        });
        Route::middleware('check_permission:view_organization')->group(function () {
            Route::get('/organization/{organization}', [OrganizationController::class, "show"]);
        });
        Route::middleware('check_permission:add_organization')->group(function () {
            Route::post('/organization', [OrganizationController::class, "store"]);
        });
        Route::middleware('check_permission:update_data_organization')->group(function () {
            Route::match(['put', 'patch'], '/organization/{organization}', [OrganizationController::class, "update"]);
            // Ciudades y departamentos
                // Lista de Ciudades
            Route::get('/cities', [LocationCityController::class, "index"]);
                // Lista de Municipios por ciudad
            Route::get('/city/{city}/municipalities', [LocationMunicipalityController::class, "show"]);
        });
        Route::middleware('check_permission:delete_organization')->group(function () {
            Route::delete('/organization/{organization}', [OrganizationController::class, "destroy"]);
        });
        Route::middleware('check_permission:list_user_by_organization')->group(function () {
            Route::get('/organization/{organization}/users', [OrganizationController::class, "users_by_organization"]);
        });

        // Roles
        Route::middleware('check_permission:view_list_roles')->group(function () {
            Route::get('/roles', [RoleController::class, "index"]);
        });
        Route::middleware('check_permission:change_role_by_user', 'blocking_change_role')->group(function () {
            Route::post('/user/change_role', [RoleController::class, "change_role_by_user"]);
        });
    });
});
