<?php

namespace App\Modules\Lesson\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\LessonRequest;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonManager extends Controller
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
            $Lesson = Lesson::get();
            $grade = Grade::get();

            return view($this->GetPreView() . 'Add', compact('userId', 'permissions', 'Lesson', 'grade'));
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Add Data
    public function Add(LessonRequest $request)
    {

        Lesson::create($request->all());

        return redirect()->back()->with('success',
            'افزودن درس با موفقیت انجام شد.'
        )->withInput();
    }

    //Return Edit Views
    public function EditView($id)
    {
        if (Auth::guard('web')->check() == true) {
            $id = Lesson::findOrFail($id);

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
            $Lesson = Lesson::get();
            $grade = Grade::get();
            $gradeSelect = Grade::where('id', $id['grade_id'])
                ->first();
            $baseSelect = Base::where('id', $id['base_id'])
                ->first();

            return view($this->GetPreView() . 'Edit', compact('path', 'userId', 'permissions', 'Lesson', 'grade', 'gradeSelect', 'baseSelect'))->with(['data' => $id]);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Edit Data
    public function Edit(LessonRequest $request, $id)
    {
        $Lesson = Lesson::findOrFail($id);
        $Lesson->update($request->all());
        return redirect(route('Lesson.Add.View'))->with('success',
            'ویرایش درس با موفقیت انجام شد.'
        )->withInput();
    }

    public function BaseSelect(Request $request)
    {
        $grade_id = $request->grade_id;
        $baseSelect = Base::where('grade_id', $grade_id)
            ->get();
        if ($grade_id) {
            $output = '<option value="0">انتخاب نشده</option>';

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
        return $output;
    }

    public function Table(Request $request)
    {
        $userId = Auth::user()->id;

        $userSelect = Users::where('id', $userId)
            ->first();
        $userCategorySelect = UserCategory::where('id', $userSelect->user_category_id)
            ->first();
        $base_id = $request->baseIds;
        $grade_id = $request->grade_id;
        $LessonId = $request->lessonId;

        if ($userCategorySelect->id == '1') {
            $Lesson = Lesson::where('grade_id', $grade_id)
                ->where('base_id', $base_id)
                ->get();
        } else {
            $Lesson = Lesson::where('grade_id', $grade_id)
                ->where('base_id', $base_id)
                ->where('user_id', $userId)
                ->orWhere('user_id', '1')
                ->where('grade_id', $grade_id)
                ->where('base_id', $base_id)
                ->get();
        }
        $gradeSelect = Grade::where('id', $grade_id)->first();
        $baseSelect = Base::where('id', $base_id)->first();
        $output = '
                    <style>
                        #tr_' . $LessonId . ' {
                            background: #DCDFE2;
                        }
                    </style>
        ';
        if (!Auth()->user()->hasPermission('Lesson.Edit')) {
            $output .= '
                    <script>
                        $(".fieldset").remove()
                    </script>
                ';
        }
        if ($grade_id) {
            if (!$Lesson->isEmpty()) {

                if ($LessonId) {
                    $output .= '
                    <script>
                    $(".fieldset").remove()
                    $(".bx-x").remove()
                    </script>

                    ';
                }
                if ($userCategorySelect->id == '1') {
                    $output .= '
                <div class="card">
                    <div class="scrollbar-external_wrapper">
                        <div class="scrollbar-external">
                            <div class="table-">
                                <table class="table table-transparent mb0">
                                    <tbody>
                                        <tr style="text-align: center;background: #DBE5F4;">
                                            <th style="border: none"><div style="padding: 15px;">دروس موجود در <b> مقطع : </b> <b style="color: #39DA8A">' . $gradeSelect->title . '</b> , <b> پایه : </b> <b style="color: #39DA8A">' . $baseSelect->title . '</b></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="table-extended-chechbox" class="table table-transparent">
                                    <thead>
                                    <tr>
                                        <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                        <th>شناسه</th>
                                        <th>عنوان</th>
                                        <th>کاربر ایجاد کننده</th>
                                    </tr>
                                    </thead>
                                    <tbody>
            ';
                } else {
                    $output .= '
                <div class="card">
                    <div class="scrollbar-external_wrapper">
                        <div class="scrollbar-external">
                            <div class="table-">
                                <table class="table table-transparent mb0">
                                    <tbody>
                                        <tr style="text-align: center;background: #DBE5F4;">
                                            <th style="border: none"><div style="padding: 15px;">دروس مجود در <b> مقطع : </b> <b style="color: #39DA8A">' . $gradeSelect->title . '</b> , <b> پایه : </b> <b style="color: #39DA8A">' . $baseSelect->title . '</b></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="table-extended-chechbox" class="table table-transparent">
                                    <thead>
                                    <tr>
                                        <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                        <th>شناسه</th>
                                        <th>عنوان</th>
                                    </tr>
                                    </thead>
                                    <tbody>
            ';
                }
                $row = 0;
                foreach ($Lesson as $item) {
                    $userCreate[$row] = Users::where('id', $item['user_id'])
                        ->first();
                    $output .= '
                        <tr class="text-center" id="tr_' . $item['id'] . '">
                            <td>
                                <fieldset class="fieldset">
                                    <div class="radio radio-shadow">
                                        <input type="radio" class="radioshadow"
                                               id="radioshadow' . $item['id'] . '"
                                               name="edit"
                                               value="' . $item['id'] . '">
                                        <label for="radioshadow' . $item['id'] . '"></label>
                                    </div>
                                </fieldset>
                            </td>
                            <td class="text-bold-500">' . $item['id'] . '</td>
                            <td>' . $item['title'] . '</td>
                             <td>' . $userCreate[$row]->name . ' ' . $userCreate[$row]->family . '</td>
                        </tr>
                ';
                    $row++;
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
                    <img src="' . asset('Assets/Admin/images/noResult3.png') . '"
                         style="width: 200px;margin: 0 auto" alt="">
                    <p class="pt10">
                        آیتمی جهت نمایش وجود ندارد!
                    </p>
                </div>
            ';
            }
        } elseif (!$grade_id) {
            $output .= '
                <div class="text-center">
                    <img src="' . asset('Assets/Admin/images/noResult3.png') . '"
                         style="width: 200px;margin: 0 auto" alt="">
                    <p class="pt10">
                        برای مشاهده ی دروس، مقطع تحصیلی و پایه تحصیلی مورد نظر را انتخاب نمایید
                    </p>
                </div>
            ';
        }


        $output .= '
            <script>
                $("input[type=radio][name=edit]").change(function () {
                    var url = "' . route("Lesson.Edit", ":id") . '";
                    url = url.replace(":id", this.value);
                    $(".stocks_list a").remove();
                    $(".stocks_list").append("<a>ویرایش</a></li>");
                    $(".stocks_list a").addClass("btn btn-primary mr-1 mb-1 edit-btn float_right");
                    $(".stocks_list a").attr("href" , url);
                });
                $(".radioshadow").click(function () {
                    var inputValue = $(this).attr("value");
                    var targetBox = $("." + inputValue);
                    $(".bx-x").not(targetBox).css("display", "block");
                    $(".edit-btn").not(targetBox).css("display", "block");
                    $(targetBox).hide();
                });
                $(".bx-x").click(function () {
                    $(".radioshadow").prop("checked", false);
                    $(".bx-x").css("display", "none");
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
                    "targets": [0,1]
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
