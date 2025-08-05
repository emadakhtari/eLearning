<?php

namespace App\Modules\SchoolList\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\Principal\Admin\Models\Principal;
use App\Modules\School\Admin\Models\School;
use App\Modules\Supervisor\Admin\Models\Supervisor;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Kavenegar;

class SchoolListManager extends Controller
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

//Return List Views
    public function ListView()
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
            $state = DB::table('state')->get();
            return view($this->GetPreView() . 'List', compact('userId', 'permissions', 'state'));
        } else {
            return redirect(route('UsersLoginView'));
        }
    }


    //Return Edit Views
    public function EditView($id)
    {
        if (Auth::guard('web')->check() == true) {
            $id = School::findOrFail($id);
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
            $state = DB::table('state')->get();
            $userSelect = Users::where('id', $userId)
                ->first();
            $userCategorySelect = UserCategory::where('id', $userSelect->user_category_id)
                ->first();
            if ($userCategorySelect->id == '1') {
                $grade = Grade::get();
            } else {
                $grade = Grade::where('user_id', $userId)
                    ->orWhere('user_id', 1)
                    ->get();
            }
            $assignSelect = AssignGradeBase::where('school_id', $id->id)
                ->get();

            $assignFirst = AssignGradeBase::where('school_id', $id->id)
                ->first();

            $gradeFirst = Grade::where('id' , $assignFirst->grade_id)
                ->first();

            if (!$assignSelect->isEmpty()) {
                $row1 = 0;
                foreach ($assignSelect as $item) {
                    $gradeSelect[$row1] = Grade::where('id', $item->grade_id)->first();
                    $baseSelect[$row1] = Base::where('id', $item->base_id)->first();
                    $row1++;
                }
            } else {
                $gradeSelect =[];
                $baseSelect =[];
            }
            $principalSelect = Principal::where('school_id', $id->id)->first();
            $deputySelect = Deputy::where('school_id', $id->id)->first();
            $supervisorSelect = Supervisor::where('school_id', $id->id)->first();

            return view($this->GetPreView() . 'Edit', compact('path', 'userId', 'permissions', 'state', 'grade', 'assignSelect', 'gradeSelect', 'baseSelect', 'principalSelect', 'deputySelect', 'supervisorSelect', 'assignFirst', 'gradeFirst'))->with(['data' => $id]);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Edit Data
    public function Edit(Request $request, $id)
    {

        $userId = Auth::user()->id;
        $created_at = date('Y-m-d H:i:s');
        $School = School::findOrFail($id);
        $School->update([
            'code' => null,
            'user_id' => $userId,
            'title' => $request->title,
            'province' => $request->province,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'area_code' => $request->area_code,
            'phone' => $request->phone,
            'register_type' => $request->register_type,
            'this_domain' => "0",
            'subdomain' => "0",
            'subdomain_name' => null,
            'another_domain' => "0",
            'another_domain_name' => null,
            'updated_at' => $created_at,
        ]);

        $pieces1 = explode("#", rtrim($request->grade_base[0], '#'));
        if ($pieces1) {
            if (AssignGradeBase::where('school_id', $id)->exists()) {
                AssignGradeBase::where('school_id', $id)->delete();
            }
        }

        foreach ($pieces1 as $item2) {
            $pieces2 = explode("*", $item2);
            AssignGradeBase::create(
                [
                    'user_id' => $userId,
                    'grade_id' => $pieces2[0],
                    'base_id' => $pieces2[1],
                    'school_id' => $School->id,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,

                ]
            );
        }
        $PrincipalSelect =  Principal::where('school_id', $id)->first();
        $Principal= Principal::findOrFail($PrincipalSelect->id);
        if ($request->password_principal) {
            $Principal->update([
                'name' => $request->name_principal,
                'family' => $request->family_principal,
                'phone' => $request->phone_principal,
                'national_code' => $request->national_code_principal,
                'password' => bcrypt($request->password_principal),
                'school_id' => $School->id,
                'email' => $request->email_principal,
                'updated_at' => $created_at,
            ]);
        } else {
            $Principal->update([
                'name' => $request->name_principal,
                'family' => $request->family_principal,
                'phone' => $request->phone_principal,
                'national_code' => $request->national_code_principal,
                'school_id' => $School->id,
                'email' => $request->email_principal,
                'updated_at' => $created_at,
            ]);
        }

        $DeputySelect =  Deputy::where('school_id', $id)->first();
        if ($request->password_deputy) {
            $DeputySelect->update([
                'name' => $request->name_deputy,
                'family' => $request->family_deputy,
                'phone' => $request->phone_deputy,
                'national_code' => $request->national_code_deputy,
                'password' => bcrypt($request->password_deputy),
                'school_id' => $School->id,
                'email' => $request->email_deputy,
                'updated_at' => $created_at,
            ]);
        } else {
            $DeputySelect->update([
                'name' => $request->name_deputy,
                'family' => $request->family_deputy,
                'phone' => $request->phone_deputy,
                'national_code' => $request->national_code_deputy,
                'school_id' => $School->id,
                'email' => $request->email_deputy,
                'updated_at' => $created_at,
            ]);
        }

        $SupervisorSelect =  Supervisor::where('school_id', $id)->first();
        if ($request->password_supervisor) {
            $SupervisorSelect->update([
                'name' => $request->name_supervisor,
                'family' => $request->family_supervisor,
                'phone' => $request->phone_supervisor,
                'national_code' => $request->national_code_supervisor,
                'password' => bcrypt($request->password_supervisor),
                'school_id' => $School->id,
                'email' => $request->email_supervisor,
                'updated_at' => $created_at,
            ]);
        } else {
            $SupervisorSelect->update([
                'name' => $request->name_supervisor,
                'family' => $request->family_supervisor,
                'phone' => $request->phone_supervisor,
                'national_code' => $request->national_code_supervisor,
                'school_id' => $School->id,
                'email' => $request->email_supervisor,
                'updated_at' => $created_at,
            ]);
        }
        return redirect()->back()->with('success',
            'ویرایش مرکز آموزش با موفقیت انجام شد.'
        )->withInput();
    }

    public function checkBase(Request $request)
    {
        $base_id = $request->base_id;
        $schoolId = $request->schoolId;
        $assignId = $request->assignId;
        $checkBase = ClassAssign::where('school_id',$schoolId)
            ->where('base_id',$base_id)
            ->first();
        $output = '';
        if ($checkBase) {
            $output .= '
            <script>
                $(".stocks_listEdit a").remove();
                $(".stocks_list a").remove();
                toastr.error("پایه انتخاب شده برای کلاسی در این مرکز آموزش انتخاب شده است. شما قادر به حذف نمی باشید.").css("width", "100%")
            </script>
            ';
        } else {
            $output .= '
            <div class="stocks_listEdit"></div>
            <script>
                $(".stocks_list a").remove();
                $(".stocks_listEdit a").remove();
                $(".stocks_listEdit").append("<a onclick=\'stocks_listEdit('.$base_id.')\'  >پایه انتخاب شده حذف شود.</a>");
                $(".stocks_listEdit a").addClass("btn btn-danger mr-1 mb-1 edit-btn stocks_listBtn");
                $(".stocks_listEdit a").attr("id", '.$assignId.');
                $(".bx-x").css("display", "block");
        function stocks_listEdit(url) {
            swal({
                    title: "آیا از حذف شدن پایه اطمینان دارید؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "بله, حذف شود!",
                    cancelButtonText: "خیر, حذف نشود!",
                    cancelButtonClass: "btn-success",
                    showLoaderOnConfirm: false,
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $("#tr'.$assignId.'").remove();
                        swal("", "محتوا شما حذف شد.", "success");
                        $(".stocks_list a").remove();
                        $(".bx-x").css("display", "none");
                    } else {
                        swal("", "محتوا شما در امان است!", "error");
                    }
                });
        }
            </script>
            ';
        }
        return $output;
    }
    public function sendCode(Request $request)
    {
        if ($request->this_domain == null && $request->subdomain == null && $request->another_domain == null) {
            return response()->json(['error' => ['لطفا دامنه اینترنتی مرکز آموزش را انتخاب نمایید']]);
        } elseif ($request->subdomain == 1 && $request->subdomain_name == null) {
            return response()->json(['error' => ['لطفا در صورت انتخاب زیر دامنه، نام زیر دامنه را وارد نمایید']]);
        } elseif ($request->another_domain == 1 && $request->another_domain_name == null) {
            return response()->json(['error' => ['لطفا در صورت انتخاب دامنه دیگر، نام دامنه را وارد نمایید']]);
        } else {
            $rules = array(
                'title' => 'nullable','unique:school,title,' . $request->schoolId,
                'subdomain' => 'nullable','unique:school,subdomain,' . $request->schoolId,
                'subdomain_name' => 'nullable','unique:school,subdomain_name,' . $request->schoolId,
                'another_domain_name' => 'nullable','unique:school,another_domain_name,' . $request->schoolId,
            );
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $userId = Auth::user()->id;
            $UserSelect= Users::where('id',$userId)
                ->first();
            $verify_code = rand(1000, 9999);
            $receptor = $UserSelect->phone;
            $token = $verify_code;
            $template = "CoronaVerify";
            $type = "sms";//sms | call

            Kavenegar::VerifyLookup($receptor, $token, '', '', $template, $type);

            $output = '';
            $grade_base = '';
            foreach ($request->grade_base as $item) {
                $grade_base .= $item;
            }

            if ($request->this_domain == null) {
                $this_domainVerify = '0';
            } else {
                $this_domainVerify = '1';
            }
            if ($request->subdomain == null) {
                $subdomainVerify = '0';
            } else {
                $subdomainVerify = '1';
            }
            if ($request->another_domain == null) {
                $another_domainVerify = '0';
            } else {
                $another_domainVerify = '1';
            }

            $output .= '
            <div class="row">
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <div class="position-relative has-icon-left">
                            <input type="hidden" name="verify_code" id="verify_code" value="' . $verify_code . '">
                            <input type="hidden" name="user_idVerify" id="user_idVerify" value="' . $userId . '">

                            ' ./* school*/
                '
                            <input type="hidden" name="titleVerify" id="titleVerify" value="' . $request->title . '">
                            <input type="hidden" name="provinceVerify" id="provinceVerify" value="' . $request->province . '">
                            <input type="hidden" name="cityVerify" id="cityVerify" value="' . $request->city . '">
                            <input type="hidden" name="addressVerify" id="addressVerify" value="' . $request->address . '">
                            <input type="hidden" name="postal_codeVerify" id="postal_codeVerify" value="' . $request->postal_code . '">
                            <input type="hidden" name="area_codeVerify" id="area_codeVerify" value="' . $request->area_code . '">
                            <input type="hidden" name="phoneVerify" id="phoneVerify" value="' . $request->phone . '">
                            <input type="hidden" name="this_domainVerify" id="this_domainVerify" value="' . $this_domainVerify . '">
                            <input type="hidden" name="subdomainVerify" id="subdomainVerify" value="' . $subdomainVerify . '">
                            <input type="hidden" name="subdomain_nameVerify" id="subdomain_nameVerify" value="' . $request->subdomain_name . '">
                            <input type="hidden" name="another_domainVerify" id="another_domainVerify" value="' . $another_domainVerify . '">
                            <input type="hidden" name="another_domain_nameVerify" id="another_domain_nameVerify" value="' . $request->another_domain_name . '">

                            ' ./* grade_base*/
                '

                            <input type="hidden" name="grade_baseVerify[]" id="grade_baseVerify" value="' . $grade_base . '">

                            ' ./* Principal*/
                '
                            <input type="hidden" name="name_principalVerify" id="name_principalVerify" value="' . $request->name_principal . '">
                            <input type="hidden" name="family_principalVerify" id="family_principalVerify" value="' . $request->family_principal . '">
                            <input type="hidden" name="phone_principalVerify" id="phone_principalVerify" value="' . $request->phone_principal . '">
                            <input type="hidden" name="national_code_principalVerify" id="national_code_principalVerify" value="' . $request->national_code_principal . '">
                            <input type="hidden" name="password_principalVerify" id="password_principalVerify" value="' . $request->password_principal . '">
                            <input type="hidden" name="email_principalVerify" id="email_principalVerify" value="' . $request->email_principal . '">


                            ' ./* Deputy*/
                '
                            <input type="hidden" name="name_deputyVerify" id="name_deputyVerify" value="' . $request->name_deputy . '">
                            <input type="hidden" name="family_deputyVerify" id="family_deputyVerify" value="' . $request->family_deputy . '">
                            <input type="hidden" name="phone_deputyVerify" id="phone_deputyVerify" value="' . $request->phone_deputy . '">
                            <input type="hidden" name="national_code_deputyVerify" id="national_code_deputyVerify" value="' . $request->national_code_deputy . '">
                            <input type="hidden" name="password_deputyVerify" id="password_deputyVerify" value="' . $request->password_deputy . '">
                            <input type="hidden" name="email_deputyVerify" id="email_deputyVerify" value="' . $request->email_deputy . '">




                            ' ./* Supervisor*/
                '
                            <input type="hidden" name="name_supervisorVerify" id="name_supervisorVerify" value="' . $request->name_supervisor . '">
                            <input type="hidden" name="family_supervisorVerify" id="family_supervisorVerify" value="' . $request->family_supervisor . '">
                            <input type="hidden" name="phone_supervisorVerify" id="phone_supervisorVerify" value="' . $request->phone_supervisor . '">
                            <input type="hidden" name="national_code_supervisorVerify" id="national_code_supervisorVerify" value="' . $request->national_code_supervisor . '">
                            <input type="hidden" name="password_supervisorVerify" id="password_supervisorVerify" value="' . $request->password_supervisor . '">
                            <input type="hidden" name="email_supervisorVerify" id="email_supervisorVerify" value="' . $request->email_supervisor . '">



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
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }

    }

    public function checkCode(Request $request)
    {

        $user_id = $request->user_idVerify;
        $userId = Auth::user()->id;
        $created_at = date('Y-m-d H:i:s');
        $School = School::findOrFail($request->schoolId);
        $School->update([
            'code' => null,
            'user_id' => $user_id,
            'title' => $request->titleVerify,
            'province' => $request->provinceVerify,
            'city' => $request->cityVerify,
            'address' => $request->addressVerify,
            'postal_code' => $request->postal_codeVerify,
            'area_code' => $request->area_codeVerify,
            'phone' => $request->phoneVerify,
            'this_domain' => $request->this_domainVerify,
            'subdomain' => $request->subdomainVerify,
            'subdomain_name' => $request->subdomain_nameVerify,
            'another_domain' => $request->another_domainVerify,
            'another_domain_name' => $request->another_domain_nameVerify,
            'updated_at' => $created_at,
        ]);

        $pieces1 = explode("#", rtrim($request->grade_baseVerify[0], '#'));
        if ($pieces1) {
            if (AssignGradeBase::where('school_id', $request->schoolId)->exists()) {
                AssignGradeBase::where('school_id', $request->schoolId)->delete();
            }
        }

        foreach ($pieces1 as $item2) {
            $pieces2 = explode("*", $item2);
            AssignGradeBase::create(
                [
                    'user_id' => $userId,
                    'grade_id' => $pieces2[0],
                    'base_id' => $pieces2[1],
                    'school_id' => $School->id,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,

                ]
            );
        }
        $PrincipalSelect =  Principal::where('school_id', $request->schoolId)->first();
        $Principal= Principal::findOrFail($PrincipalSelect->id);
        if ($request->password_principalVerify) {
            $Principal->update([
                'name' => $request->name_principalVerify,
                'family' => $request->family_principalVerify,
                'phone' => $request->phone_principalVerify,
                'national_code' => $request->national_code_principalVerify,
                'password' => bcrypt($request->password_principalVerify),
                'school_id' => $School->id,
                'email' => $request->email_principalVerify,
                'updated_at' => $created_at,
            ]);
        } else {
            $Principal->update([
                'name' => $request->name_principalVerify,
                'family' => $request->family_principalVerify,
                'phone' => $request->phone_principalVerify,
                'national_code' => $request->national_code_principalVerify,
                'school_id' => $School->id,
                'email' => $request->email_principalVerify,
                'updated_at' => $created_at,
            ]);
        }

        $DeputySelect =  Deputy::where('school_id', $request->schoolId)->first();
        if ($request->password_deputyVerify) {
            $DeputySelect->update([
                'name' => $request->name_deputyVerify,
                'family' => $request->family_deputyVerify,
                'phone' => $request->phone_deputyVerify,
                'national_code' => $request->national_code_deputyVerify,
                'password' => bcrypt($request->password_deputyVerify),
                'school_id' => $School->id,
                'email' => $request->email_deputyVerify,
                'updated_at' => $created_at,
            ]);
        } else {
            $DeputySelect->update([
                'name' => $request->name_deputyVerify,
                'family' => $request->family_deputyVerify,
                'phone' => $request->phone_deputyVerify,
                'national_code' => $request->national_code_deputyVerify,
                'school_id' => $School->id,
                'email' => $request->email_deputyVerify,
                'updated_at' => $created_at,
            ]);
        }

        $SupervisorSelect =  Supervisor::where('school_id', $request->schoolId)->first();
        if ($request->password_supervisorVerify) {
            $SupervisorSelect->update([
                'name' => $request->name_supervisorVerify,
                'family' => $request->family_supervisorVerify,
                'phone' => $request->phone_supervisorVerify,
                'national_code' => $request->national_code_supervisorVerify,
                'password' => bcrypt($request->password_supervisorVerify),
                'school_id' => $School->id,
                'email' => $request->email_supervisorVerify,
                'updated_at' => $created_at,
            ]);
        } else {
            $SupervisorSelect->update([
                'name' => $request->name_supervisorVerify,
                'family' => $request->family_supervisorVerify,
                'phone' => $request->phone_supervisorVerify,
                'national_code' => $request->national_code_supervisorVerify,
                'school_id' => $School->id,
                'email' => $request->email_supervisorVerify,
                'updated_at' => $created_at,
            ]);
        }

        return redirect()->back()->with('success',
            'مرکز آموزش با موفقیت ثبت گردید.'
        )->withInput();
    }
}
