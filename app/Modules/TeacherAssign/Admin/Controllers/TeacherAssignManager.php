<?php

namespace App\Modules\TeacherAssign\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\TeacherAssignRequest;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\School\Admin\Models\School;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\TeacherAssign\Admin\Models\TeacherAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAssignManager extends Controller
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

            $teacherSelect = Teacher::where('school_id', $SchoolSelect->id)
                ->get();

            $baseSelectList = AssignGradeBase::where('school_id', $SchoolSelect->id)
                ->get();
            $row = 0;
            foreach ($baseSelectList as $item) {
                $baseSelect[$row] = Base::where('id', $item->base_id)
                    ->first();
                $row++;
            }

            return view($this->GetPreView() . 'Add', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'teacherSelect', 'baseSelectList', 'baseSelect'));
        } else {
            return redirect(route('DeputyLoginView'));
        }
    }

    //Add Data
    public function Add(TeacherAssignRequest $request)
    {
        $deputyId = Auth::guard('deputy')->id();
        $school_id = $request->school_id;
        $teacher_id = $request->teacher_id;
        $base_id = $request->base_id;
        $lesson_id = $request->lesson_id;
        $class_id = $request->class_id;
        $checkDouble = TeacherAssign::where('deputy_id', $deputyId)
            ->where('school_id', $school_id)
            ->where('base_id', $base_id)
            ->where('lesson_id', $lesson_id)
            ->where('class_id', $class_id)
            ->first();


        if ($checkDouble) {
            return redirect()->back()->with('error',
                'کلاس مورد نظر در این پایه و کلاس انتخاب شده است!'
            )->withInput();
        } else {
            TeacherAssign::create($request->all());
            return redirect()->back()->with('success',
                'تخصیص کلاس با موفقیت انجام شد.'
            )->withInput();
        }
    }


    public function info(Request $request)
    {
        $teacher_id = $request->teacher_id;

        $TeacherSelect = Teacher::where('id', $teacher_id)
            ->first();
        $output = '<label for="teacher_name">نام مدرس</label>';
        $output .= '<input type="text" class="form-control" id="teacher_name" value="' . $TeacherSelect->name . '" disabled>';
        $output .= '<br>';
        $output .= '<label for="teacher_name">نام خانوادگی مدرس</label>';
        $output .= '<input type="text" class="form-control" id="teacher_name" value="' . $TeacherSelect->family . '" disabled>';
        return $output;
    }

    public function lesson(Request $request)
    {
        $base_id = $request->base_id;
        $baseList = Lesson::where('base_id', $base_id)
            ->get();
        if ($base_id) {
            $output = '<option value="0">انتخاب نشده</option>';

            foreach ($baseList as $item) {
                $output .= '<option value="' . $item->id . '">' . $item->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }
        return $output;
    }

    public function class(Request $request)
    {
        $school_id = $request->school_id;
        $base_id = $request->base_id;
        $classList = ClassAssign::where('base_id', $base_id)
            ->where('school_id', $school_id)
            ->get();
        if ($base_id) {
            $output = '<option value="0">انتخاب نشده</option>';

            foreach ($classList as $item) {
                $output .= '<option value="' . $item->id . '">' . $item->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }
        return $output;
    }

    public function Table(Request $request)
    {
        $deputy_id = $request->deputy_id;
        $school_id = $request->school_id;
        $teacher_id = $request->teacher_id;

        $TeacherAssign = TeacherAssign::where('teacher_id', $teacher_id)
            ->where('deputy_id', $deputy_id)
            ->where('school_id', $school_id)
            ->get();
        $teacherSelect = Teacher::where('id', $teacher_id)
            ->first();

        $deputyId = Auth::guard('deputy')->id();
        $deputyAdmin = Deputy::where('id', $deputyId)
            ->first();

        $output = '';
        if ($teacher_id) {
            if (!$TeacherAssign->isEmpty()) {
                $output .= '
                <div class="card">
                    <div class="scrollbar-external_wrapper">
                        <div class="scrollbar-external">
                            <div class="table-">
                                <table class="table table-transparent mb0">
                                    <tbody>
                                        <tr style="text-align: center;background: #DBE5F4;">
                                            <th style="border: none"><div style="padding: 15px;"><b>فهرست کلاس های تدریس  : </b> <b style="color: #39DA8A">' . $teacherSelect->name . ' ' . $teacherSelect->family . '</b></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="table-extended-chechbox" class="table table-transparent">
                                    <thead>
                                    <tr>
                                        <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                        <th>شناسه</th>
                                        <th>پایه</th>
                                        <th>درس</th>
                                        <th>کلاس</th>
                                    </tr>
                                    </thead>
                                    <tbody>
            ';
                $row = 0;
                if ($deputyAdmin->hasPermission('TeacherAssign.Delete') || $deputyAdmin->level == "1") {
                    foreach ($TeacherAssign as $item) {
                        $baseSelect = Base::where('id', $item['base_id'])
                            ->first();
                        $lessonSelect = Lesson::where('id', $item['lesson_id'])
                            ->first();
                        $classSelect = ClassAssign::where('id', $item['class_id'])
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
                            <td>' . $baseSelect->title . '</td>
                            <td>' . $lessonSelect->title . '</td>
                            <td>' . $classSelect->title . '</td>
                        </tr>
                ';
                        $row++;
                    }
                } else {
                    foreach ($TeacherAssign as $item) {
                        $baseSelect = Base::where('id', $item['base_id'])
                            ->first();
                        $lessonSelect = Lesson::where('id', $item['lesson_id'])
                            ->first();
                        $classSelect = ClassAssign::where('id', $item['class_id'])
                            ->first();
                        $output .= '
                        <tr class="text-center" id="tr_' . $item['id'] . '">
                            <td>
                            </td>
                            <td class="text-bold-500">' . $item['id'] . '</td>
                            <td>' . $baseSelect->title . '</td>
                            <td>' . $lessonSelect->title . '</td>
                            <td>' . $classSelect->title . '</td>
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
        } elseif (!$teacher_id) {
            $output .= '
                <div class="text-center">
                    <img src="' . asset('Assets/Admin/images/noResult3.png') . '"
                         style="width: 200px;margin: 0 auto" alt="">
                    <p class="pt10">
                        برای مشاهده ی فهرست کلاس ها، مدرس مورد نظر را انتخاب نمایید
                    </p>
                </div>
            ';
        }
        $output .= '
            <script>
            $(".stocks_list").on("click", function () {
                swal({
                        title: "آیا از حذف این محتوا اطمینان دارید؟",
                        text: "پس از حذف قادر به بازیابی این محتوا نخواهید بود!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "بله, حذف شود!",
                        cancelButtonText: "خیر, حذف نشود!",
                        showLoaderOnConfirm: false,
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            var class_id = $(".stocks_list a").attr("rel");
                            var _token = $("#_token").val();
                            $(".lds-ripple-content").show();
                            $.ajax({
                                type: "POST",
                                url: "' . route('TeacherAssign.Delete') . '",
                                data: {class_id: class_id, _token: _token},
                                success: function (deleteOutput) {
                                    $("#deleteOutput").html(deleteOutput);
                                    $(".deleteClass").remove();
                                    $(".radioshadow").prop("checked", false);
                                    $(".bx-x").css("display", "none");
                                }
                            });
                        } else {
                            swal("", "محتوا شما در امان است!", "error");
                        }
                    });

            });
                $("input[type=radio][name=edit]").change(function () {
                    var url =  this.value;
                    $(".stocks_list a").remove();
                    $(".stocks_list").append("<a>حذف</a></li>");
                    $(".stocks_list a").addClass("btn btn-danger mr-1 mb-1 edit-btn float_right deleteClass");
                    $(".stocks_list a").attr("id" , "del");
                    $(".stocks_list a").attr("rel" , url);
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
                    "targets": [0,2,3,4]
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

    public function Delete(Request $request)
    {
        $class_id = $request->class_id;
        TeacherAssign::where('id', $class_id)->delete();
        $output = '';
        $output .= '
            <script>
                $("#tr_' . $class_id . '").remove();
                $(".sweet-overlay").remove();
                $(".showSweetAlert").remove();
                $(".lds-ripple-content").hide();
                Command: toastr["success"]("تخصیص مدرس با موفقیت حذف گردید", "");
            </script>
        ';
        return $output;
    }
}
