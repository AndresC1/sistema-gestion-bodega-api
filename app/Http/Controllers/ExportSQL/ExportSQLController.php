<?php

namespace App\Http\Controllers\ExportSQL;

use App\Http\Controllers\Controller;
use App\Models\ExportSQL\TableToExportForOrganizations;
use App\Models\ExportSQL\TableToExportGlobal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ExportSQLController extends Controller
{
    public function exportSQLForOrganizations()
    {
        $organizationId = auth()->user()->organization_id;
        $companyName = DB::table('organizations')->where('id', $organizationId)->value('name');

        $sqlFileName = 'export_' . $companyName . '_' . date('Y-m-d_His') . '.sql';
        $sqlContent = '';

        foreach (TableToExportForOrganizations::getTablesToExport() as $table) {
            $query = "SELECT * FROM {$table} WHERE organization_id = {$organizationId};";

            $results = DB::select($query);

            $sqlContent .= "\n\n/* Data table - {$table} */\n\n";
            foreach ($results as $row) {
                $values = implode("', '", (array) $row);
                $sqlContent .= "INSERT INTO {$table} VALUES ('$values');\n";
            }
        }

        return $this->responseSQL($sqlContent, $sqlFileName);
    }
    private function responseSQL($sqlContent, $sqlFileName){
        $response = Response::make($sqlContent, 200);

        $response->header('Content-Type', 'application/sql');
        $response->header('Content-Disposition', "attachment; filename={$sqlFileName}");

        return $response;
    }
    public function exportSQLGlobal(){
        $sqlFileName = 'export_global_' . date('Y-m-d_His') . '.sql';
        $sqlContent = '';
        foreach (TableToExportGlobal::getTablesToExport() as $table) {
            $query = "SELECT * FROM {$table};";

            $results = DB::select($query);

            $sqlContent .= "\n\n/* Data table - {$table} */\n\n";
            foreach ($results as $row) {
                $values = implode("', '", (array) $row);
                $sqlContent .= "INSERT INTO {$table} VALUES ('$values');\n";
            }
        }

        return $this->responseSQL($sqlContent, $sqlFileName);
    }
}
