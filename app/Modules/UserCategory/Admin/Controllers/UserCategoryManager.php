<?php


namespace App\Modules\UserCategory\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\UserCategoryRequest;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use Illuminate\Support\Facades\Auth;

class UserCategoryManager extends Controller
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
    public function AddUserCategoryView()
    {
        if (Auth::guard('web')->check() == true) {

            $userId = Auth::user()->id;
            $userAllSinglePermissions = [];
            $permissions = json_decode(Auth::user()->permissions, true)['admin'];
            if (!empty($permissions)) {
                foreach ($permissions as $key => $permission) {
                    foreach ($permission['permissions'] as $perm_json) {
                        $perm = json_decode($perm_json, true);
                        if (!empty($perm)) {
                            foreach ($perm[key($perm)] as $access_name) {
                                array_push($userAllSinglePermissions, $access_name);
                            }
                        } else {
                            array_push($userAllSinglePermissions, $key . '.' . $perm_json);
                        }
                    }
                }
            }
            $modules = CoreCommon::GetAdminModulesPermissions();
            $usersCategory = UserCategory::get();
            return view($this->GetPreView() . 'AddUserCategory', compact('userId', 'permissions', 'usersCategory'))->with('modules', $modules);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Controllers That Do Somethings
    public function AddUserCategory(UserCategoryRequest $request)
    {
        $info = [];
        $modulesRequest = $request->input('modules');
        $statusRequest = $request->input('status');
        $titleRequest = $request->input('title');
        if (!empty($modulesRequest)) {
            foreach ($modulesRequest as $moduleName) {
                $moduleNameRequest = $request->input($moduleName);
                $temp = [];
                $temp['permissions'] = $moduleNameRequest;
                $info[$moduleName] = $temp;
            }
        }

        if (!empty($info)) {
            $permissions = ['admin' => $info];
            if ($request['status']) {
                $status = $request['status'];
            } else {
                $status = '0';
            }

            $request->request->add(['status' => $status]);
            $request->request->add(['permissions' => json_encode($permissions)]);
            UserCategory::create($request->all());;
            return redirect()->back()->with('success',
                'افزودن گروه با موفقیت انجام شد.'
            )->withInput();
        } else {
            return redirect()->back()
                ->withErrors('دسترسی گروه را مشخص نمایید')
                ->withInput();
        }

    }


    public function EditUserCategoryView($id)
    {
        if (Auth::guard('web')->check() == true) {

            $modules = CoreCommon::GetAdminModulesPermissions();
            $userCategory = UserCategory::GetWithId($id);
            if (!empty($userCategory)) {
                $userId = Auth::user()->id;
                $userAllSinglePermissions = [];
                $permissions = json_decode(Auth::user()->permissions, true)['admin'];
                if (!empty($permissions)) {
                    foreach ($permissions as $key => $permission) {
                        foreach ($permission['permissions'] as $perm_json) {
                            $perm = json_decode($perm_json, true);
                            if (!empty($perm)) {
                                foreach ($perm[key($perm)] as $access_name) {
                                    array_push($userAllSinglePermissions, $access_name);
                                }
                            } else {
                                array_push($userAllSinglePermissions, $key . '.' . $perm_json);
                            }
                        }
                    }
                }
                $usersCategory = UserCategory::get();
                return view($this->GetPreView() . 'EditUserCategory', compact('userId', 'permissions', 'usersCategory'))->with('data', ['userCategory' => $userCategory, 'modules' => $modules, 'id' => $id]);
            } else {
                return redirect('/Admin');
            }

        } else {
            return redirect(route('UsersLoginView'));
        }
    }


    public function EditUserCategory(UserCategoryRequest $request, $id)
    {
        $info = [];
        $modulesRequest = $request->input('modules');
        $titleRequest = $request->input('title');
        $statusRequest = $request->input('status');
        if (!empty($modulesRequest)) {
            foreach ($modulesRequest as $moduleName) {
                $moduleNameRequest = $request->input($moduleName);
                if (!empty($moduleNameRequest)) {
                    $temp = [];
                    $moduleName_allPermRequest = $request->input($moduleName . '_allPerm');
                    if (!empty($moduleName_allPermRequest)) {
                        $temp['permAll'] = 'yes';
                    } else {
                        $temp['permAll'] = 'no';
                    }
                    $temp['permissions'] = $moduleNameRequest;
                    $info[$moduleName] = $temp;
                }
            }
        }

        if (!empty($info)) {
            $permissions = ['admin' => $info];
            if ($request['status']) {
                $status = $request['status'];
            } else {
                $status = '0';
            }
            $UserCategory = UserCategory::findOrFail($id);

            $request->merge(['status' => $status]);
            $request->merge(['permissions' => $permissions]);
            $UserCategory->update($request->all());

            return redirect(route('UserCategory.Add.View'))->with('success',
                'ویرایش کاربر با موفقیت انجام شد.'
            )->withInput();
        } else {
            return redirect()->back()
                ->withErrors('دسترسی گروه را مشخص نمایید')
                ->withInput();
        }

    }

}
