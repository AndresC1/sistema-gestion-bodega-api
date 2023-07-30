<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Location\CityController as LocationCityController;
use App\Http\Controllers\Location\MunicipalityController as LocationMunicipalityController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Autenticación
    Route::post('/auth/login', [AuthController::class, "login"])->middleware('check_status_user');
    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/register', [AuthController::class, "register"]);
        Route::post('/auth/logout', [AuthController::class, "logout"]);
        
        // Usuarios
            // Informacion de usuario
        Route::get('/user/info', [UserController::class, "show"]);
            // Actualizacion de datos de usuario
        Route::patch('/user/{user}', [UserController::class, "update"]);
            // Estados de los usuarios
        Route::get('/user/{user}/change_status', [UserController::class, "change_status"]);
            // Listado de usuarios
        Route::get('/users', [UserController::class, "index"]);
        
        // Ciudades y departamentos
            // Lista de Ciudades
        Route::get('/cities', [LocationCityController::class, "index"]);
            // Lista de Municipios por ciudad
        Route::get('/city/{city}/municipalities', [LocationMunicipalityController::class, "show"]);

        // Sectores
        Route::get('/sectors', [SectorController::class, "index"]);
        Route::get('/sector/{sector}/organizations', [SectorController::class, "organization_for_sector"]);

        // Organizaciones
        Route::apiResource('/organizations', OrganizationController::class);
        Route::get('/organization/{organization}/users', [OrganizationController::class, "users_by_organization"]);
    });
});
