<?php


namespace App\Modules\Users\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\UserRequest;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Kavenegar;

class UsersManager extends Controller
{


    public function GetModuleName()
    {
        $dd = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest = json_decode($manifestJson, true);
        $moduleName = $manifest['title'];
        return $moduleName;
    }

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

    public function AddUsersView()
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
            $userCategories = UserCategory::GetAll();
            $users = Users::where('type', "1")
                ->get();
            return view($this->GetPreView() . 'AddUsersView', compact('userId', 'permissions', 'users'))->with('userCategories', $userCategories);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }
    //Controllers That Do Somethings
    public function AddUsers(UserRequest $request)
    {
        if (!empty($request->user_category_id)) {
            $user_category_id = implode(',', $request->user_category_id);
            if ($user_category_id != 1) {
                $rules = array(
                    'group_name' => [
                        'required',
                        'unique:users'
                    ],
                    'group_address' => [
                        'required',
                    ],
                    'group_postalCode' => [
                        'required',
                        'digits:10',
                        'numeric',
                        'unique:users'
                    ],
                    'group_phone' => [
                        'required',
                        'numeric',
                        'unique:users'
                    ]
                );
            } else {
                $rules = array();
            }
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $info = [];
            $modulesRequest = $request->input('modules');
            if (!empty($modulesRequest)) {
                foreach ($modulesRequest as $module) {
                    $permissionInputValue = explode('_', $module);

                    $category_id = $permissionInputValue[0];
                    $moduleName = $permissionInputValue[1];
                    $moduleNameRequest = $request->input($moduleName);
                    if (!empty($moduleNameRequest)) {

                        $temp = [];
                        $moduleName_permAllRequest = $request->input($moduleName . '_permAll');
                        if (!empty($moduleName_permAllRequest)) {
                            $temp['permAll'] = 'yes';
                        } else {
                            $temp['permAll'] = 'no';
                        }
                        $temp = [];
                        $temp['permissions'] = $moduleNameRequest;
                        $info[$moduleName] = $temp;
                    }

                }
                $request->merge(['permissions' => ['admin' => $info]]);

                if (!empty($request->user_category_id)) {
                    $request->merge(['user_category_id' => implode(',', $request->user_category_id)]);

                } else {
                    $request->merge(['user_category_id' => ""]);

                }

                if ($request['status']) {
                    $status = $request['status'];
                } else {
                    $status = '0';
                }

                if ($request['level']) {
                    $level = $request['level'];
                } else {
                    $level = '0';
                }

                if ($request->group_logo) {
                    if ($_FILES["group_logo"]["size"] > 0) {
                        $group_logo = $request->file('group_logo');
                        $filenamegroup_logo = 'group_logo' . time() . '_' . $_FILES["group_logo"]["name"];
                        $pathgroup_logo = public_path('/upload/group/group_logo/' . $filenamegroup_logo);
                        $pathgroup_logo = str_replace("main-laravel/public", "public_html", $pathgroup_logo);
                        @move_uploaded_file($_FILES["group_logo"]["tmp_name"], $pathgroup_logo);
                    }
                } else {
                    $filenamegroup_logo = null;
                }

                $request->merge(['group_logo' => $filenamegroup_logo]);
                $request->merge(['status' => $status]);
                $request->merge(['level' => $level]);
                $Users = Users::create($request->all());;
                $Users->update([
                    'group_logo' => $filenamegroup_logo,
                ]);
                return redirect()->back()->with('success',
                    'افزودن کاربر با موفقیت انجام شد.'
                )->withInput();
            }
        } else {
            return redirect()->back()->withErrors([$validator->errors()->all()]);
        }
    }

    public function EditUsersView($id)
    {
        if (Auth::guard('web')->check() == true) {
            $userPermissions = json_decode(Auth::guard('web')->user()->permissions, true)['admin'];
            $permInfo = $this->extractPermissions($userPermissions);
            $path = str_replace("public/", "", asset(""));
            $userCategories = UserCategory::GetAll();
            $user = Users::Get($id);
            $permissionses = $this->extractPermissions($user->permissions['admin']);
            foreach ($permInfo as $category => $actions) {
                foreach ($actions as $action => $status) {
                    if (isset($permissionses[$category][$action])) {
                        $permInfo[$category][$action] = true;
                    }
                }
            }
            $userCategorys = UserCategory::GetWithId($user['user_category_id']);

            $user_category_ids = explode(',', $user->user_category_id);
            $userId = Auth::user()->id;
            if ($id == $userId) {
                Users::where('id', $userId)->update(
                    [
                        'code' => null
                    ]
                );
            }
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
            $userAdmin = Users::where('id', $userId)
                ->first();

            $users = Users::where('type', "1")
                ->get();


            return view($this->GetPreView() . 'EditUsersView', compact('path', 'user_category_ids', 'userId', 'permissions', 'userCategorys', 'userAdmin', 'users'))->with('data', ['userCategories' => $userCategories, 'user' => $user, 'userPermissions' => $userPermissions, 'userCategorys' => $userCategorys, 'id' => $id, "permInfo" => $permInfo]);
        } else {
            return redirect(route('UsersLoginView'));
        }

    }

    public function EditUsers(UserRequest $request, $id)
    {
//        dd($request->all());
        $data = Users::findOrFail($id);

        $info = [];
        $modulesRequest = $request->input('modules');
        if (!empty($modulesRequest)) {
            foreach ($modulesRequest as $module) {
                $permissionInputValue = explode('_', $module);

                $category_id = $permissionInputValue[0];
                $moduleName = $permissionInputValue[1];
                $moduleNameRequest = $request->input($moduleName);
                if (!empty($moduleNameRequest)) {
                    $temp = [];
                    $temp['permissions'] = $moduleNameRequest;
                    $info[$moduleName] = $temp;
                }
            }
            $request->merge(['permissions' => ['admin' => $info]]);
        }


        if ($request['status']) {
            $status = $request['status'];
        } else {
            $status = '0';
        }

        if ($request['level']) {
            $level = $request['level'];
        } else {
            $level = '0';
        }

        $request->merge(['status' => $status]);
        $request->merge(['level' => $level]);
        if ($request['password']) {
            $data->update($request->all());
        } else {
            $password = $request->except('password');
            $data->update($password);

        }

//        $data->update($request->all());
        if (Auth()->user()->hasPermission('Users.Edit')) {
            return redirect(route('Users.Add.View'))->with('success',
                'ویرایش کاربر با موفقیت انجام شد.'
            )->withInput();
        } else {
            return redirect(route('list'))->with('success',
                'ویرایش کاربر با موفقیت انجام شد.'
            )->withInput();
        }


    }

    private function extractPermissions($permissions)
    {

        $data = [];
        foreach ($permissions as $categoryName => $categoryValues) {
            if (!empty($categoryValues['permissions'])) {

                foreach ($categoryValues['permissions'] as $permissionGroup) {

                    $temp = json_decode($permissionGroup, true);
                    if (!empty($temp)) {

                        foreach ($temp as $actionName => $item) {
                            $data[$categoryName][$actionName] = false;
                        }
                    } else {
                        $data[$categoryName][$permissionGroup] = false;
                    }
                }
            }

        }
        return $data;
    }


    public function sendCode(Request $request)
    {
        $verify_code = rand(1000, 9999);
        $usId = $request->userId;
        $password = $request->password;
        DB::table('users')
            ->where('id', $usId)
            ->update(
                ['code' => $verify_code]
            );

        $userSelect = Users::where('id', $usId)->first();


        $receptor = $userSelect->phone;
        $token = $verify_code;
        $template = "CoronaVerify";
        $type = "sms";//sms | call
        Kavenegar::VerifyLookup($receptor, $token, '', '', $template, $type);
        $mobile_No = $request->phone;
        $output = '
            <div class="row">
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <input type="hidden" name="pass" id="pass" value="' . $password . '">
                            <input type="hidden" name="usId" id="usId" value="' . $usId . '">
                            <input type="hidden" name="userCode" id="userCode" value="' . $userSelect->code . '">
                            <input type="number" class="form-control" id="code" name="code" value="" placeholder="کد چهار رقمی" aria-required="true">
                            <div class="form-control-position">
                                <i class="bx bxs-check-shield"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-6" >
                    <a href="#" class="btn btn-primary mr-1 mb-1" id="checkVerify">تایید نهایی</a>
                </div>
            </div>
            <script>
                $(function () {
                    $("#code").keyup(function (e) {
                        var ctrlKey = 67, vKey = 86;
                        if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                            $("#code").val(persianToEnglish($(this).val()));
                        }
                    });
                });

                function persianToEnglish(input) {
                    var inputstring = input;
                    var persian = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"]
                    var english = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
                    for (var i = 0; i < 10; i++) {
                        var regex = new RegExp(persian[i], "g");
                        inputstring = inputstring.toString().replace(regex, english[i]);
                    }
                    return inputstring;
                }
            </script>
            ';

        return $output;

    }

    public function checkCode(Request $request)
    {
        $usId = $request->usId;
        $pass = bcrypt($request->pass);;
        DB::table('users')
            ->where('id', $usId)
            ->update(
                [
                    'code' => null,
                    'password' => $pass,
                ]
            );
    }
}
