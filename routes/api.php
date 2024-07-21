<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Location\CityController as LocationCityController;
use App\Http\Controllers\Location\MunicipalityController as LocationMunicipalityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductInputController;
use App\Http\Controllers\DetailsPurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Conversion\ConverterController;
use App\Http\Controllers\ExportarExcel\ExportController;
use App\Http\Controllers\Earning\EarningsController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Information\AplicationController;

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
        Route::patch('/user', [UserController::class, "update"]);
            // Cambio de estado para usuario
        Route::middleware('check_permission:change_status_by_user', 'check_role_super_admin', 'match_organization', 'check_different_role')->group(function () {
            Route::patch('/user/{user}/change_status', [UserController::class, "change_status"]);
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
        Route::middleware('check_permission:see_my_organization')->group(function () {
            Route::get('/organization_info', [OrganizationController::class, "see_organization"]);
        });
        Route::middleware('check_permission:add_organization')->group(function () {
            Route::post('/organization', [OrganizationController::class, "store"]);
        });
        Route::middleware('check_permission:view_list_cities_and_municipalities')->group(function () {
            // Lista de Ciudades
            Route::get('/cities', [LocationCityController::class, "index"]);
            // Lista de Municipios por ciudad
            Route::get('/city/{city}/municipalities', [LocationMunicipalityController::class, "show"]);
        });
        Route::middleware('check_permission:update_data_organization')->group(function () {
            Route::patch('/organization/{organization}', [OrganizationController::class, "update"]);
        });
        Route::middleware('check_permission:update_my_organization')->group(function () {
            Route::post('/organization_update', [OrganizationController::class, "update_my_organization"]);
        });
        Route::middleware('check_permission:delete_organization')->group(function () {
            Route::delete('/organization/{organization}', [OrganizationController::class, "destroy"]);
        });
        Route::middleware('check_permission:list_user_by_organization')->group(function () {
            Route::get('/organization/{organization}/users', [OrganizationController::class, "users_by_organization"]);
        });
        Route::middleware('check_permission:list_user_my_organization')->group(function () {
            Route::get('/organization_users', [OrganizationController::class, "list_user"]);
        });

        // Roles
        Route::middleware('check_permission:view_list_roles')->group(function () {
            Route::get('/roles', [RoleController::class, "index"]);
        });
        Route::middleware('check_permission:change_role_by_user', 'blocking_change_role', 'check_both_super_admin', 'check_admin_change_user_super_admin', 'check_different_organization', 'check_both_admin')->group(function () {
            Route::post('/user/change_role', [RoleController::class, "change_role_by_user"]);
        });
        // Cambio de contraseña
        Route::post('/user/change_password', [UserController::class, "change_password"]);

        // Proveedores
        Route::middleware('check_permission:list_providers_my_organization')->group(function () {
            Route::get('/providers', [ProviderController::class, "index"]);
        });
        Route::middleware('check_permission:view_list_providers_by_organization')->group(function () {
            Route::get('/organization/{organization}/providers', [ProviderController::class, "list_provider_by_organization"]);
        });
        Route::middleware('check_permission:add_providers')->group(function () {
            Route::post('/provider', [ProviderController::class, "store"]);
        });
        Route::middleware('check_permission:update_providers', 'check_different_organization_for_provider')->group(function () {
            Route::patch('/provider/{provider}', [ProviderController::class, "update"]);
        });
        Route::middleware('check_permission:change_status_provider', 'check_different_organization_for_provider')->group(function () {
            Route::patch('/provider/{provider}/change_status', [ProviderController::class, "change_status"]);
        });
        Route::middleware('check_permission:see_my_providers', 'check_different_organization_for_provider')->group(function () {
            Route::get('/provider/{provider}', [ProviderController::class, "show"]);
        });

        // Clientes
        Route::middleware('check_permission:list_clients_my_organization')->group(function () {
            Route::get('/clients', [ClientController::class, "index"]);
        });
        Route::middleware('check_permission:view_list_clients_by_organization')->group(function () {
            Route::get('/organization/{organization}/clients', [ClientController::class, "list_clients_by_organization"]);
        });
        Route::middleware('check_permission:add_clients')->group(function () {
            Route::post('/client', [ClientController::class, "store"]);
        });
        Route::middleware('check_permission:update_clients', 'check_different_organization_for_client')->group(function () {
            Route::patch('/client/{client}', [ClientController::class, "update"]);
        });
        Route::middleware('check_permission:change_status_client', 'check_different_organization_for_client')->group(function () {
            Route::patch('/client/{client}/change_status', [ClientController::class, "change_status"]);
        });
        Route::middleware('check_permission:change_status_client', 'check_different_organization_for_client')->group(function () {
            Route::get('/client/{client}', [ClientController::class, "show"]);
        });

        // Productos
        Route::get('/products/{name}/search', [ProductController::class, "search"]);
        Route::apiResource('/product', ProductController::class)->only(['store', 'show', 'index']);

        // Inventarios
        Route::middleware('check_permission:view_inventory')->group(function () {
            Route::apiResource('/inventory', InventoryController::class)->only(['index', 'show']);
            Route::prefix('inventory')->group(function () {
                Route::get('/stock/min', [InventoryController::class, "list_min_stock"]);
                Route::get('/search/product', [InventoryController::class, "search_for_product"]);
                Route::get('/MP/list', [InventoryController::class, "list_product_in_MP"]);
                Route::get('PT/list', [InventoryController::class, "list_product_in_PT"]);
            });


        });
        Route::middleware('check_permission:add_inventory')->group(function () {
            Route::post('/inventory', [InventoryController::class, "store"]);
        });

        // Compras
        Route::middleware('check_permission:view_purchase')->group(function () {
            Route::get('/purchases', [PurchaseController::class, "index"]);
        });
        Route::middleware('check_permission:register_purchase', 'validate_listDetailsPurchase')->group(function () {
            Route::post('/purchase', [PurchaseController::class, "store"]);
        });

        // Entrada de producto terminado
        Route::prefix('register')->middleware('check_permission:register_finished_product')->group(function () {
            Route::post('/finished_product', [ProductInputController::class, "store"]);
        });
        Route::middleware('check_permission:register_finished_product')->group(function () {
            Route::get('/details_purchase', [DetailsPurchaseController::class, "index"]);
        });
        Route::middleware('check_permission:register_sale')->group(function () {
            Route::get('/product_input', [ProductInputController::class, "show"]);
            Route::post('/sale', [SaleController::class, "store"]);
            Route::get('/sale', [SaleController::class, "index"]);
        });
        Route::get('/list_measurements', [ConverterController::class, "list_units"]);
        Route::get('/list_type_measurements', [ConverterController::class, "list_types_measurements"]);
        Route::get('/converter', [ConverterController::class, "converter"]);

        Route::prefix('backup')->middleware('check_permission:export_database_global')->group(function () {
            Route::post('/export', [BackupController::class, "exportBackup"]);
            Route::post('/download', [BackupController::class, "downloadBackup"]);
            Route::get('/list', [BackupController::class, "listBackups"]);
            Route::post('/delete', [BackupController::class, "deleteBackup"]);
            Route::post('/import', [BackupController::class, "restoreBackup"]);
        });

        //exportar
        Route::post('/complete/export', [ExportController::class, 'CompleteExport']);
        Route::middleware('check_permission:see_earnings_of_my_organization')->group(function () {
            Route::get('/earnings_total', [EarningsController::class, "short_term_profits"]);
            Route::get('/earnings_last_year', [EarningsController::class, "calculate_earnings_last_year"]);
            Route::get('/earnings_last_month', [EarningsController::class, "calculate_earnings_for_day"]);
        });

        Route::get('/complete/export/Nada', [ExportController::class, 'Nada']);
        Route::prefix('complete/export')->middleware('validate_date_range')->group(function () {
            Route::get('/MP', [ExportController::class, 'InventoryMP']);
            Route::get('/PT', [ExportController::class, 'InventoryPT']);
            Route::get('/BestSeller', [ExportController::class, 'BestSeller']);
            Route::get('/Sales', [ExportController::class, 'Sales']);
            Route::get('/Purchase', [ExportController::class, 'Purchase']);
            Route::get('/Low', [ExportController::class, 'Low']);
        });
        Route::middleware('check_permission:see_dashboard_super_admin')->group(function () {
            Route::get('/information', [AplicationController::class, "dashboard_super_admin"]);
        });
    });
});
