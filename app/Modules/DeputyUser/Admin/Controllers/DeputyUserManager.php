<?php


namespace App\Modules\DeputyUser\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\DeputyUser\Admin\Models\DeputyUser;
use App\Modules\School\Admin\Models\School;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeputyUserManager extends Controller
{

    public function GetModuleName()
    {
        $dd = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest = json_decode($manifestJson, true);
        $moduleName = $manifest['title'];
        return $moduleName;
    }

    public function AddDeputyUserView()
    {
        if (Auth::guard('deputy')->check() == true) {
            $deputyId = Auth::guard('deputy')->id();
            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();

            return view($this->GetPreView() . 'AddDeputyUser', compact('deputyId', 'deputyAdmin', 'SchoolSelect'));
        } else {
            return redirect(route('DeputyLoginView'));
        }
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

    public function AddDeputyUser(Request $request)
    {
        $deputyId = Auth::guard('deputy')->id();
        $deputySelect = DeputyUser::where('id', $deputyId)
            ->first();

        $modulesRequest = $request->input('modules');
        $checkDeputy = DeputyUser::where('national_code', $request->national_code)
            ->first();
        if ($checkDeputy) {
            return redirect()->back()->withErrors(['کاربر معاونت با کد ملی وارد شده قبلا در سیستم ثبت شده است.']);
        } else {
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
                $infopermissions = json_encode(['admin' => $info]);
                $request->merge(['permissions' => $infopermissions]);
            }

            if ($request['status']) {
                $status = "1";
            } else {
                $status = '0';
            }

            $level = '2';
            $request->merge(['status' => $status]);
            $request->merge(['level' => $level]);
            $request->merge(['above_id' => $deputyId]);
            $request->merge(['school_id' => $deputySelect->school_id]);
            $request->merge(['password' => bcrypt($request->password)]);

            Deputy::create($request->all());

            return redirect()->back()->with('success',
                'افزودن کاربر معاونت با موفقیت انجام شد.'
            )->withInput();
        }

    }

    public function EditDeputyUserView($id)
    {

        if (Auth::guard('deputy')->check() == true) {
            $id = DeputyUser::findOrFail($id);

            $deputyId = Auth::guard('deputy')->id();

            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();

            $userPermissions = json_decode($id->permissions, true)['admin'];

            return view($this->GetPreView() . 'EditDeputyUser', compact('deputyId', 'SchoolSelect', 'userPermissions'))->with(['data' => $id]);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    public function EditDeputyUser(Request $request, $id)
    {
//        dd($request->all());
        $data = Deputy::findOrFail($id);
        $deputyId = Auth::guard('deputy')->id();
        $deputySelect = DeputyUser::where('id', $deputyId)
            ->first();
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
            $infopermissions = json_encode(['admin' => $info]);
            $request->merge(['permissions' => $infopermissions]);
        }

        if ($request['status']) {
            $status = "1";
        } else {
            $status = '0';
        }

        $level = '2';
        $request->merge(['status' => $status]);
        $request->merge(['level' => $level]);
        $request->merge(['above_id' => $deputyId]);
        $request->merge(['school_id' => $deputySelect->school_id]);

        if ($request['password']) {
            $request->merge(['password' => bcrypt($request->password)]);
            $data->update($request->all());
        } else {
            $password = $request->except('password');
            $data->update($password);
        }

        return redirect(route('DeputyUser.Add.View'))->with('success',
            'ویرایش کاربر معاون مرکز آموزش با موفقیت انجام شد'
        )->withInput();
    }

    //Table
    public function Table(Request $request)
    {
        $above_id = $request->above_id;
        $deputy_id = $request->deputy_id;

        $deputys = Deputy::where('above_id', $above_id)
            ->get();

        $output = '
                    <style>
                        #tr_'.$deputy_id.' {
                            background: #DCDFE2;
                        }
                    </style>
        ';
        if (!$deputys->isEmpty()) {
            if ($deputy_id) {
                $output .= '
                <script>
                $(".fieldset").remove()
                $("#table-extended-chechbox .bx-x").remove()
                </script>

                ';
            }
            $output .= '
            <div class="card">
                <div class="scrollbar-external_wrapper">
                    <div class="scrollbar-external">
                        <div class="table-">
                            <table class="table table-transparent mb0">
                                <tbody>
                                    <tr style="text-align: center;background: #DBE5F4;">
                                        <th style="border: none"><div style="padding: 15px;"><b>فهرست کاربر معاونت</b> </div></th>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="table-extended-chechbox" class="table table-transparent">
                                <thead>
                                <tr>
                                    <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                    <th>شناسه</th>
                                    <th>نام و نام خانوادگی </th>
                                    <th>کد ملی</th>
                                </tr>
                                </thead>
                                <tbody>
        ';
            foreach ($deputys as $item) {
                $output .= '
                    <tr class="text-center" id="tr_'.$item['id'].'">
                        <td>
                            <fieldset class="fieldset">
                                <div class="radio radio-shadow">
                                    <input type="radio" class="radioshadow"
                                           id="radioshadow'.$item['id'].'"
                                           name="edit"
                                           value="'.$item['id'].'">
                                    <label for="radioshadow'.$item['id'].'"></label>
                                </div>
                            </fieldset>
                        </td>
                        <td class="text-bold-500">'.$item['id'].'</td>
                        <td>'.$item['name'].' '.$item['family'].'</td>
                        <td>'.$item['national_code'].'</td>
                    </tr>
            ';
            }


            $output .= '
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="external-scroll_x">
                <div class="scroll-element_outer">
                    <div class="scroll-element_size"></div>
                    <div class="scroll-element_track"></div>
                    <div class="scroll-bar"></div>
                </div>
            </div>
            <div class="external-scroll_y">
                <div class="scroll-element_outer">
                    <div class="scroll-element_size"></div>
                    <div class="scroll-element_track"></div>
                    <div class="scroll-bar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-12 text-right stocks_list">
    </div>
            ';
        } else {
            $output .= '
            <div class="text-center">
                <img src="'.asset('Assets/Admin/images/noResult3.png').'"
                     style="width: 200px;margin: 0 auto" alt="">
                <p class="pt10">
                    کاربر معاون برای مرکز آموزش شما تعریف نشده است
                </p>
            </div>
        ';
        }
        $output .='
            <script>
                $("input[type=radio][name=edit]").change(function () {
                    var url = "'.route("DeputyUser.Edit", ":id").'";
                    url = url.replace(":id", this.value);
                    $(".stocks_list a").remove();
                    $(".stocks_list").append("<a>ویرایش</a></li>");
                    $(".stocks_list a").addClass("btn btn-primary mr-1 mb-1 edit-btn float_right");
                    $(".stocks_list a").attr("href" , url);
                });
                $(".radioshadow").click(function () {
                    var inputValue = $(this).attr("value");
                    var targetBox = $("." + inputValue);
                    $("#table-extended-chechbox .bx-x").not(targetBox).css("display", "block");
                    $(".edit-btn").not(targetBox).css("display", "block");
                    $(targetBox).hide();
                });
                $("#table-extended-chechbox .bx-x").click(function () {
                    $(".radioshadow").prop("checked", false);
                    $("#table-extended-chechbox .bx-x").css("display", "none");
                    $(".stocks_list a").remove();
                });

                $(".scrollbar-external").scrollbar({
                    "autoScrollSize": false,
                    "scrollx": $(".external-scroll_x"),
                    "scrolly": $(".external-scroll_y")
                });

            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    "sEmptyTable": "هیچ داده ای در جدول وجود ندارد",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "در حال بارگزاری...",
                    "sProcessing": "در حال پردازش...",
                    "sSearch": "",
                    "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                    "oAria": {
                        "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                        "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                    }
                }
            });

            // table extended checkbox
            var tablecheckbox = $("#table-extended-chechbox").DataTable({
                "searching": true,
                "lengthChange": true,
                "paging": false,
                "bInfo": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0]
                }, //to disable sortying in col 0,3 & 4
                ],
                "select": "multi",
                "order": [
                    [1, "desc"]
                ]
            });
        </script>
        ';


        return $output;
    }

}
