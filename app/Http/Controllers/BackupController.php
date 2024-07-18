<?php

namespace App\Http\Controllers;

use App\Http\Requests\Backup\ImportBackupRequest;
use App\Models\Backup;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    function exportBackup()
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        $backupName = 'backup_' . now('America/Managua')->format('Y-m-d_His') . '.sql';
        $backupPath = storage_path('app/backup/' . $backupName);

        $command = "mysqldump -h {$host} -P {$port} -u {$user} -p{$password} {$database} > {$backupPath}";
        exec($command);

        $fileBackup = Backup::create([
            'name' => $backupName,
            'path' => $backupPath,
            'disk' => 'local',
            'size' => round(filesize($backupPath) / 1024 / 1024, 2)."MB",
            'type' => 'sql',
            'created_at' => now('America/Managua')->format('Y-m-d H:i:s'),
            'updated_at' => now('America/Managua')->format('Y-m-d H:i:s')
        ]);
        exec($command);


        return response()->json([
            'backup' => $fileBackup,
            'message' => 'Backup created successfully',
            'status' => 200
        ], 200);
    }

    function downloadBackup(ImportBackupRequest $request)
    {
        $request->validated();
        $backup = Backup::find($request->backup_id);

        if($backup->deleted_at != null){
            return response()->json([
                'message' => 'Backup not found',
                'status' => 400
            ], 400);
        }

        return response()->download($backup->path);
    }

    function listBackups()
    {
        $backups = Backup::Where('deleted_at', null)->get();

        return response()->json([
            'backups' => $backups,
            'message' => 'Backups obtained successfully',
            'status' => 200
        ], 200);
    }

    function deleteBackup(ImportBackupRequest $request)
    {
        $request->validated();
        $backup = Backup::find($request->backup_id);

        if($backup->deleted_at == null){
            $backup->deleted_at = now('America/Managua')->format('Y-m-d H:i:s');
            $backup->deleted_by = auth()->user()->id;
            $backup->save();
        }

        return response()->json([
            'message' => 'Backup deleted successfully',
            'status' => 200
        ], 200);
    }

    function restoreBackup(ImportBackupRequest $request)
    {
        $request->validated();
        $backup = Backup::find($request->backup_id);

        if($backup->deleted_at != null){
            return response()->json([
                'message' => 'Backup not found',
                'status' => 400
            ], 400);
        }

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        $command = "mysql -h {$host} -P {$port} -u {$user} -p{$password} {$database} < {$backup->path}";

        exec($command);

        return response()->json([
            'message' => 'Backup restored successfully',
            'status' => 200
        ], 200);
    }
}
