<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\Location\CityController as LocationCityController;
use App\Http\Controllers\Location\MunicipalityController as LocationMunicipalityController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\SectorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Ciudades y departamentos
    Route::get('/cities', [LocationCityController::class, "index"]);
    Route::get('/city/{city}/municipalities', [LocationMunicipalityController::class, "show"]);
    // Sectores
    Route::get('/sectors', [SectorController::class, "index"]);
    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        //
    });
});
