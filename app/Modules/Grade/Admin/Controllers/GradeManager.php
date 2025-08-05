<?php

namespace App\Modules\Grade\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\GradeRequest;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Support\Facades\Auth;

class GradeManager extends Controller
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

    //Return Add Views
    public function AddView()
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
            $userSelect = Users::where('id' , $userId)
                ->first();
            $userCategorySelect = UserCategory::where('id' , $userSelect->user_category_id)
                ->first();
            if ($userCategorySelect->id == '1') {
                $grade = Grade::get();
                $row=0;
                if (!$grade->isEmpty()) {
                    foreach($grade as $item) {
                        $userCreate[$row] = Users::where('id' , $item->user_id)
                            ->first();
                        $row++;
                    }
                } else {
                    $userCreate = null;
                }

            } else {
                $grade = Grade::where('user_id', $userId)
                    ->orWhere('user_id', '1')
                    ->get();
                $userCreate = null;
            }

            return view($this->GetPreView() . 'Add', compact('userId', 'permissions', 'grade', 'userSelect', 'userCategorySelect', 'userCreate'));
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Add Data
    public function Add(GradeRequest $request)
    {
        if ($request['forced']) {
            $forced = '1';
        } else {
            $forced = '0';
        }
        $request->request->add(['forced' => $forced]);
        Grade::create($request->all());

        return redirect()->back()->with('success',
            'افزودن مقطع با موفقیت انجام شد.'
        )->withInput();
    }

    //Return Edit Views
    public function EditView($id)
    {
        if (Auth::guard('web')->check() == true) {
            $id = Grade::findOrFail($id);

            $path = str_replace("public/", "", asset(""));
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
            $userSelect = Users::where('id' , $userId)
                ->first();
            $userCategorySelect = UserCategory::where('id' , $userSelect->user_category_id)
                ->first();
            if ($userCategorySelect->id == '1') {
                $grade = Grade::get();
                $row=0;
                if (!$grade->isEmpty()) {
                    foreach($grade as $item) {
                        $userCreate[$row] = Users::where('id' , $item->user_id)
                            ->first();
                        $row++;
                    }
                } else {
                    $userCreate = null;
                }

            } else {
                $grade = Grade::where('user_id', $userId)
                    ->orWhere('user_id', '1')
                    ->get();
                $userCreate = null;
            }
            return view($this->GetPreView() . 'Edit', compact('path', 'userId', 'permissions', 'grade', 'userSelect', 'userCategorySelect', 'userCreate'))->with(['data' => $id]);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Edit Data
    public function Edit(GradeRequest $request, $id)
    {
        $Grade = Grade::findOrFail($id);
        if ($request['forced']) {
            $forced = '1';
        } else {
            $forced = '0';
        }

        $request->merge(['forced' => $forced]);
        $Grade->update($request->all());
        return redirect(route('Grade.Add.View'))->with('success',
            'ویرایش مقطع با موفقیت انجام شد.'
        )->withInput();
    }


}
