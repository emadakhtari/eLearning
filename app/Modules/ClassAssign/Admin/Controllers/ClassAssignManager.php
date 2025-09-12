<?php

namespace App\Modules\ClassAssign\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\ClassAssignRequest;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\School\Admin\Models\School;
use App\Modules\TeacherAssign\Admin\Models\TeacherAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassAssignManager extends Controller
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
        if (Auth::guard('deputy')->check() == true) {
            $deputyId = Auth::guard('deputy')->id();
            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();
            $assignSelect = AssignGradeBase::where('school_id', $SchoolSelect->id)
                ->first();


            $baseSelect = Base::where('grade_id', $assignSelect->grade_id)
                ->get();


            return view($this->GetPreView() . 'Add', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'assignSelect', 'baseSelect'));
        } else {
            return redirect(route('DeputyLoginView'));
        }
    }

    //Add Data
    public function Add(ClassAssignRequest $request)
    {
        ClassAssign::create($request->all());
        return redirect()->back()->with('success',
            'افزودن درس با موفقیت انجام شد.'
        )->withInput();
    }

    public function EditView($id)
    {
        if (Auth::guard('deputy')->check() == true) {
            $id = ClassAssign::findOrFail($id);

            $deputyId = Auth::guard('deputy')->id();

            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();
            $assignSelect = AssignGradeBase::where('school_id', $SchoolSelect->id)
                ->first();

            $baseSelect = Base::where('grade_id', $assignSelect->grade_id)
                ->first();

            $gradeSelect = Grade::where('id',$id->grade_id)
                ->first();

            return view($this->GetPreView() . 'Edit', compact('deputyId',  'assignSelect', 'SchoolSelect',  'baseSelect', 'gradeSelect'))->with(['data' => $id]);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Edit Data
    public function Edit(ClassAssignRequest $request, $id)
    {
        $ClassAssign = ClassAssign::findOrFail($id);

        $ClassAssign->update($request->all());
        return redirect(route('ClassAssign.Add.View'))->with('success',
            'ویرایش درس با موفقیت انجام شد.'
        )->withInput();
    }


    public function Table(Request $request)
    {
        $class_id = $request->class_id;

        $grade_id = $request->grade_id;
        $base_id = $request->base_id;
        $deputyId = Auth::guard('deputy')->id();
        $baseSelect = Base::where('id', $base_id)
            ->first();
        $deputySelect = Deputy::where('id', $deputyId)
            ->first();
        $schholSelect = School::where('id', $deputySelect->school_id)
            ->first();

        $ClassAssign = ClassAssign::where('base_id', $base_id)
            ->where('grade_id', $grade_id)
            ->where('school_id', $schholSelect->id)
            ->get();
        $deputyAdmin = Deputy::where('id', $deputyId)
            ->first();


        $output = '
                    <style>
                        #tr_'.$class_id.' {
                            background: #DCDFE2;
                        }
                    </style>

        ';

        if ($grade_id) {

            if (!$ClassAssign->isEmpty()) {
                if ($class_id) {
                    $output .= '
                    <script>
                    $(".fieldset").remove()
                    $(".bx-x").remove()
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
                                            <th style="border: none"><div style="padding: 15px;"><b>فهرست کلاس های پایه  : </b> <b style="color: #39DA8A">' . $baseSelect->title . '</b></div></th>
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
                $row = 0;
                if ($deputyAdmin->hasPermission('ClassAssign.Edit.View') || $deputyAdmin->level == "1") {
                    foreach ($ClassAssign as $item) {
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
                        </tr>
                ';
                        $row++;
                    }
                } else {
                    foreach ($ClassAssign as $item) {
                        $output .= '
                        <tr class="text-center" id="tr_' . $item['id'] . '">
                            <td>
                            </td>
                            <td class="text-bold-500">' . $item['id'] . '</td>
                            <td>' . $item['title'] . '</td>
                        </tr>
                ';
                        $row++;
                    }
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
                        برای مشاهده ی کلاس ها، پایه تحصیلی مورد نظر را انتخاب نمایید
                    </p>
                </div>
            ';
        }
        $output .= '

            <script>
                $("input[type=radio][name=edit]").change(function () {
                    var url = "'.route("ClassAssign.Edit", ":id").'";
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
                    "targets": [0,2]
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
