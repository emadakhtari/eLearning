<?php


namespace App\Modules\Users\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use App\Http\Controllers\CoreCommon;
use Illuminate\Http\Request;

class AjaxHandler extends Controller
{

    public function GetPreView()
    {
        $dd = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest = json_decode($manifestJson, true);
        $moduleName = $manifest['title'];
        if (substr(strrchr(__DIR__, "Admin" . $dd), 6)) {
            $side = 'Admin';
        }

        $preView = $moduleName . '_' . $side . '::';
        return $preView;
    }


    //Just Return Views
    public function GetUserCategoryPermission(Request $request)
    {
        $userPermission = [];
        $userCategoryIdRequest = $request->input('userCategoryId');
        $user_idRequest = $request->input('user_id');
        $category = UserCategory::find($userCategoryIdRequest);
        $permissions_json = UserCategory::GetWithId($userCategoryIdRequest)['permissions'];
        $permissions = json_decode($permissions_json, true);
        if (!empty($user_idRequest)) {
            $userPermission = $this->getUserPermission($user_idRequest);
        }

        return view($this->GetPreView() . 'Ajax_UserCategoryPermission', compact('category', 'userPermission'))->with('modules', $permissions['admin']);
    }




    public function getUserPermission($user_id)
    {
        $user = Users::find($user_id);

        $temp = $user->permissions;
        $result = [];
        if (!empty($temp['admin'])) {
            foreach ($temp['admin'] as $module) {
                foreach ($module['permissions'] as $permission) {
                    $result[] = $permission;
                }
            }


        }

        return $result;

    }
}
