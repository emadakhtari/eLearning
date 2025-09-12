<?php


namespace App\Http\Controllers;

use App\Modules\Employee\Models\Message;
use Illuminate\Support\Facades\Auth;

class CoreCommon extends Controller
{

    public static function UserHaveAllPermission($moduleName)
    {
//        $permAll=json_decode(Auth::user()->permissions,true)['admin'][$moduleName]['permAll'];
        $permAll = json_decode(json_encode(Auth::user()->permissions), true)['admin'][$moduleName];
        if ($permAll == 'yes' || Auth::guard('web')->user()->id == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function GetModulesName()
    {
        $dd = CoreCommon::osD();
        $modules = [];
        $dirs = array_filter(glob(app_path('Modules') . $dd . '*'), 'is_dir');
        foreach ($dirs as $dir) {
            if (file_exists($dir . $dd . "Manifest.json")) {
                $manifest_json = file_get_contents($dir . $dd . "Manifest.json", "r");
                $manifest = json_decode($manifest_json, true);
                if ($manifest['status'] == 'Active') {
                    array_push($modules, substr(strrchr($dir, $dd), 1));
                }
            }
        }
        return $modules;
    }

    public static function GetAdminModulesPermissions()
    {
        $dd = CoreCommon::osD();
        $modules = [];
        $dirs = array_filter(glob(app_path('Modules') . $dd . '*'), 'is_dir');
        foreach ($dirs as $dir) {
            if (file_exists($dir . $dd . "Manifest.json") && is_dir($dir . $dd . "Admin")) {
                $manifest_json = file_get_contents($dir . $dd . "Manifest.json", "r");
                $manifest = json_decode($manifest_json, true);
                if ($manifest['status'] == 'Active' && $manifest['type'] == 'public') {
                    //array_push($modules,substr(strrchr($dir,"\'"), 1));
                    $temp = [];
                    $temp['moduleName'] = $manifest['title'];
                    $temp['permissions'] = $manifest['permissions']['admin'];
                    array_push($modules, $temp);
                }
            }
        }
        return $modules;
    }

    public static function osD()
    {
        $os_version = strtolower(php_uname());
        if (preg_match('*windows*', $os_version)) {
            return '\\';
        } else if (preg_match('*linux*', $os_version)) {
            return '/';
        } else {
            return '/';
        }
    }

}
