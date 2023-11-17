<?php

namespace App\Http\Controllers\Information;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class AplicationController extends Controller
{
    protected function disk(){
        $totalSpace = disk_total_space(storage_path("app/public"));
        $freeSpace = disk_free_space(storage_path("app/public"));
        $usedSpace = $totalSpace - $freeSpace;
        $totalSpaceInGB = round($totalSpace / 1024 / 1024 / 1024, 2);
        $freeSpaceInGB = round($freeSpace / 1024 / 1024 / 1024, 2);
        $usedSpaceInGB = round($usedSpace / 1024 / 1024 / 1024, 2);

        return [
            'unit' => 'GB',
            'totalSpace' => $totalSpaceInGB,
            'freeSpace' => $freeSpaceInGB,
            'usedSpace' => $usedSpaceInGB,
        ];
    }

    public function dashboard_super_admin(){
        $disk = $this->disk();
        $countUser = User::count();
        $UsersLogin = User::OrderBy('last_login_at', 'desc')->take(5)->select('name', 'last_login_at')->get();

        $UsersLogin->each(function ($usuario) {
            $usuario->tiempo_pasado = Carbon::parse($usuario->last_login_at)->diffForHumans();
        });

        return response()->json([
            'disk' => $disk,
            'countUser' => $countUser,
            'lastLogin' => $UsersLogin,
        ], 200);
    }
}
