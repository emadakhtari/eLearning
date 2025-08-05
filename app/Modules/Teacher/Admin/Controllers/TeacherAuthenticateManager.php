<?php

namespace App\Modules\Teacher\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Setting\Admin\Models\Setting;
use App\Modules\Teacher\Admin\Models\Teacher;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Input;


class TeacherAuthenticateManager extends Controller
{

    public function CheckPassword(Request $request)
    {
        $rules = array(
            'captcha' => 'required|captcha',
        );

        $validator = Validator::make($request->all(), $rules);
        $user = Teacher::where('national_code', $request->get('national_code'))
            ->first();


        if ($user != null) {
            if ($validator->passes()) {
                if ($request->get('password')) {
                    $password = $request->get('password');
                    $national_code = $request->get('national_code');
                    $token = $request->get('nekot');
                    $national_codeRequest = $request->input('national_code');
                    $passwordRequest = $request->input('password');
                    if (Auth::guard('teacher')->attempt(['national_code' => $national_codeRequest, 'password' => $passwordRequest])) {
                        Auth::guard('web')->logout();
                        Auth::guard('deputy')->logout();
                        $output = '';
                        return [$output, 'status' => 'true', 'url' => route('list')];
                    } else {
                        $output = 'wrongPass';
                        return ['output' => $output, 'status' => 'false'];
                    }
                }
            } else {
                $output = 'wrongCaptcha';
                return ['output' => $output, 'status' => 'false'];
            }
        } else {
            $output = 'wrongCode';
            return ['output' => $output, 'status' => 'false'];
        }

    }

    public function TeacherLoginView()
    {
//        Auth::guard('teacher')->logout();
//        dd(Auth::guard('teacher')->check());
        if (Auth::guard('teacher')->check() == true) {
            return redirect(route('list'));
        } else {
//            $pass =bcrypt('123456');
//            DB::table('teacher')->where('id', 1)->update(['password' => $pass]);
//            dd($pass);
            $setting = Setting::where('id', 1)
                ->first();
            return view($this->GetPreView() . 'TeacherLogin', compact('setting'));
        }
    }

    //Just Return Views

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

    public function TeacherLogout()
    {
        Auth::guard('teacher')->logout();
        return redirect(route('TeacherLogin'));
    }

}
