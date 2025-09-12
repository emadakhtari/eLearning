<?php


namespace App\Modules\Deputy\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\UserRequest;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\School\Admin\Models\School;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kavenegar;

class DeputyManager extends Controller
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

    public function EditDeputyView($id)
    {

        if (Auth::guard('deputy')->check() == true) {

            $deputy = Deputy::where('id',$id)->first();
            $deputyId = Auth::guard('deputy')->id();
            if ($id == $deputyId) {
                Deputy::where('id', $deputyId)->update(
                    [
                        'code' => null
                    ]
                );
            }
            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();

            $SchoolSelect = School::where('id', $deputy->school_id)
                ->first();
            $AssignGSelect = AssignGradeBase::where('school_id', $deputy->school_id)
                ->first();

            $GradeSelect = Grade::where('id', $AssignGSelect->grade_id)
                ->first();
            $provinceSelect = DB::table('state')
                ->where('id', $SchoolSelect->province)
                ->first();
            $cityeSelect = DB::table('city')
                ->where('id', $SchoolSelect->city)
                ->first();

            return view($this->GetPreView() . 'EditDeputyView', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'GradeSelect', 'provinceSelect', 'cityeSelect'))->with('data', ['id' => $id, 'deputy' => $deputy]);
        } else {
            return redirect(route('DeputyLoginView'));
        }
    }
    public function EditDeputy(UserRequest $request, $id)
    {
//        dd($request->all());
        $data = Deputy::findOrFail($id);

        if ($request['password']) {
            $data->update($request->all());
        } else {
            return redirect(route('list'))->with('success',
                'تغییری در پروفایل شما انجام نگردید.'
            )->withInput();
        }

//        $data->update($request->all());
        return redirect(route('list'))->with('success',
            'تغییر رمز عبور با موفقیت انجام شد.'
        )->withInput();
    }



    public function sendCode(Request $request)
    {
        $verify_code = rand(1000, 9999);
        $usId = $request->userId;
        $mobile_No = $request->phone;
        $password = $request->password;
        DB::table('deputy')
            ->where('id', $usId)
            ->update(
                ['code' => $verify_code]
            );

        $Deputyelect = Deputy::where('id', $usId)->first();

        $receptor = $Deputyelect->phone;
        $token = $verify_code;
        $template = "CoronaVerify";
        $type = "sms";//sms | call
        Kavenegar::VerifyLookup($receptor, $token, '', '', $template, $type);

        $output = '
            <div class="row">
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <input type="hidden" name="pass" id="pass" value="' . $password . '">
                            <input type="hidden" name="usId" id="usId" value="' . $usId . '">
                            <input type="hidden" name="userCode" id="userCode" value="' . $Deputyelect->code . '">
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
        DB::table('deputy')
            ->where('id', $usId)
            ->update(
                [
                    'code' => null,
                    'password' => $pass,
                ]
            );
    }
}
