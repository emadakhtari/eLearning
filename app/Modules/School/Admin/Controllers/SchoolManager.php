<?php

namespace App\Modules\School\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\SchoolRequest;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\Principal\Admin\Models\Principal;
use App\Modules\School\Admin\Models\School;
use App\Modules\Supervisor\Admin\Models\Supervisor;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Kavenegar;

class SchoolManager extends Controller
{
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
            $state = DB::table('state')->get();
            $userSelect = Users::where('id', $userId)
                ->first();
            $userCategorySelect = UserCategory::where('id', $userSelect->user_category_id)
                ->first();
            if ($userCategorySelect->id == '1') {
                $grade = Grade::get();
            } else {
                $grade = Grade::where('user_id', $userId)
                    ->orWhere('user_id', '1')
                    ->get();
            }
            return view($this->GetPreView() . 'Add', compact('userId', 'permissions', 'state', 'grade'));
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Return Add Views

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

    //Add Data

    public function Add(SchoolRequest $request)
    {
        $userId = Auth::user()->id;
        $created_at = date('Y-m-d H:i:s');
        $School = School::create(
            [
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
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        $pieces1 = explode("#", rtrim($request->grade_base[0], '#'));
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
        Principal::create(
            [
                'name' => $request->name_principal,
                'family' => $request->family_principal,
                'phone' => $request->phone_principal,
                'national_code' => $request->national_code_principal,
                'password' => bcrypt($request->password_principal),
                'school_id' => $School->id,
                'email' => $request->email_principal,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        Deputy::create(
            [
                'name' => $request->name_deputy,
                'family' => $request->family_deputy,
                'phone' => $request->phone_deputy,
                'national_code' => $request->national_code_deputy,
                'password' => bcrypt($request->password_deputy),
                'school_id' => $School->id,
                'email' => $request->email_deputy,
                'level' => "1",
                'permissions' => null,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        Supervisor::create(
            [
                'name' => $request->name_supervisor,
                'family' => $request->family_supervisor,
                'phone' => $request->phone_supervisor,
                'national_code' => $request->national_code_supervisor,
                'password' => bcrypt($request->password_supervisor),
                'school_id' => $School->id,
                'email' => $request->email_supervisor,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );

        return redirect()->back()->with('success',
            'مرکز آموزش با موفقیت ثبت گردید.'
        )->withInput();
    }

    public function provinceSelect(Request $request)
    {
        $province = $request->province;
        $citySelect = DB::table('city')
            ->where('State_No', $province)
            ->get();
        if ($province) {
            $output = '<option value="">انتخاب شهر</option>';

            foreach ($citySelect as $item) {
                if ($request->cityId == $item->id) {
                    $selected = ' selected';
                } else if ($request->cityOld == $item->id) {
                    $selected = ' selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $item->id . '" ' . $selected . '>' . $item->City_Name . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب شهر</option>';
        }
        return $output;
    }

    public function BaseSelect(Request $request)
    {
        $userId = Auth::user()->id;
        $grade_id = $request->grade_id;
        $gradeSelect = Grade::where('id', $grade_id)
            ->first();
        $userSelect = Users::where('id', $userId)
            ->first();
        $userCategorySelect = UserCategory::where('id', $userSelect->user_category_id)
            ->first();
        if ($userCategorySelect->id == '1') {
            $baseSelect = Base::where('grade_id', $grade_id)
                ->get();
        } else {
            $baseSelect = Base::where('grade_id', $grade_id)
                ->where('user_id', $userId)
                ->orWhere('user_id', '1')
                ->where('grade_id', $grade_id)
                ->get();
        }
        if ($gradeSelect->forced == '1') {
            $output = '
            <script>
            $("#assignBtn").hide();
</script>
            ';
            $output .= '<option value="">تمامی پایه ها اجباری می باشد</option>';
        } else {
            $output = '';
            $output .= '
            <script>
            $("#assignBtn").show();
</script>
            ';
            if ($grade_id) {
                $output .= '<option value="">انتخاب نشده</option>';

                foreach ($baseSelect as $item) {
                    if ($request->baseId == $item->id) {
                        $selected = ' selected';
                    } else {
                        $selected = '';
                    }
                    $output .= '<option value="' . $item->id . '" ' . $selected . '>' . $item->title . '</option>';
                }
            } else {
                $output = '<option value="">انتخاب نشده</option>';
            }
        }

        return $output;
    }

    public function ForceAssign(Request $request)
    {
        $grade_id = $request->grade_id;
        $gradeSelect = Grade::where('id', $grade_id)
            ->first();

        if ($gradeSelect->forced == '1') {
            $baseList = Base::where('grade_id', $grade_id)->get();
            $row1 = 1;
            $output = "";
            foreach ($baseList as $item) {
                $output .= "<tr id='tr" . $row1 . "'>
    <td>

    </td>
<td><input type='hidden' class='grade_base' name='grade_base[]' value='" . $grade_id . "*" . $item->id . "#'> " . $row1 . "</td>
<td> " . $gradeSelect->title . "</td>
<td>" . $item->title . "</td>

</tr>
        ";
                $row1++;
            }
            return $output;
        }

    }

    public function assign(Request $request)
    {
        $grade_id = $request->grade_id;
        $base_id = $request->base_id;
        $rows = $request->rows;
        $grade = Grade::where('id', $grade_id)->first();
        $base = Base::where('id', $base_id)->first();
//        $Assign = AssignGradeBase::where('grade_id', $grade_id)
//            ->where('base_id', $base_id)
//            ->get();

        $output = "<tr id='tr" . $rows . "'>
    <td>
        <fieldset class='fieldset'>
            <div class='radio radio-shadow'>
                <input type='radio' class='radioshadow'
                       id='radioshadow" . $rows . "'
                       name='edit'
                       value='" . $rows . "'>
                <label for='radioshadow" . $rows . "'></label>
            </div>
        </fieldset>
    </td>
<td><input type='hidden' class='grade_base' name='grade_base[]' value='" . $grade_id . "*" . $base_id . "#'> " . $rows . "</td>
<td> " . $grade->title . "</td>
<td>" . $base->title . "</td>

</tr>
        ";

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
                'title' => ['unique:school'],
                'subdomain_name' => ['nullable', 'unique:school'],
                'another_domain_name' => ['nullable', 'unique:school'],
            );
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $userId = Auth::user()->id;
            $UserSelect = Users::where('id', $userId)
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
        $School = School::create(
            [
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
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        $pieces1 = explode("#", rtrim($request->grade_baseVerify[0], '#'));
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
        Principal::create(
            [
                'name' => $request->name_principalVerify,
                'family' => $request->family_principalVerify,
                'phone' => $request->phone_principalVerify,
                'national_code' => $request->national_code_principalVerify,
                'password' => bcrypt($request->password_principalVerify),
                'school_id' => $School->id,
                'email' => $request->email_principalVerify,
                'level' => "1",
                'permissions' => null,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        Deputy::create(
            [
                'name' => $request->name_deputyVerify,
                'family' => $request->family_deputyVerify,
                'phone' => $request->phone_deputyVerify,
                'national_code' => $request->national_code_deputyVerify,
                'password' => bcrypt($request->password_deputyVerify),
                'school_id' => $School->id,
                'email' => $request->email_deputyVerify,
                'level' => "1",
                'permissions' => null,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        Supervisor::create(
            [
                'name' => $request->name_supervisorVerify,
                'family' => $request->family_supervisorVerify,
                'phone' => $request->phone_supervisorVerify,
                'national_code' => $request->national_code_supervisorVerify,
                'password' => bcrypt($request->password_supervisorVerify),
                'school_id' => $School->id,
                'email' => $request->email_supervisorVerify,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]
        );
        return redirect()->back()->with('success',
            'مرکز آموزش با موفقیت ثبت گردید.'
        )->withInput();
    }
}
