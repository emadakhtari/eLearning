<?php

namespace App\Modules\GeneralInformation\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Schedule\Admin\Models\Schedule;
use App\Modules\School\Admin\Models\School;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\GeneralInformation\Admin\Models\GeneralInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class GeneralInformationManager extends Controller
{

    public function AddView()
    {
        if (Auth::guard('teacher')->check() == true) {
            $teacherId = Auth::guard('teacher')->id();
            $teacherAdmin = Teacher::where('id', $teacherId)
                ->first();
            $SchoolSelect = School::where('id', $teacherAdmin->school_id)
                ->first();

            $assignSelect = AssignGradeBase::where('school_id', $SchoolSelect->id)
                ->first();

            $baseList = Base::where('grade_id', $assignSelect->grade_id)
                ->get();

            $lessonList = Lesson::where('base_id', $assignSelect->base_id)
                ->get();

            $schedule = Schedule::where('teacher_id', $teacherId)
                ->get();

            return view($this->GetPreView() . 'Add', compact('teacherId', 'teacherAdmin', 'SchoolSelect', 'assignSelect', 'baseList', 'lessonList', 'schedule'));
        } else {
            return redirect(route('TeacherLoginView'));
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

    public function Add(Request $request)
    {
        if ($request->file) {
            if ($_FILES["file"]["size"] > 0) {
                $file = $request->file('file');
                $getLastRec = GeneralInformation::latest('id')
                    ->first();
                if ($getLastRec) {
                    $getLastId = $getLastRec->id;
                } else {
                    $getLastId = 0;
                }
                $OrgName = str_replace("." . $request->file_type, "", $_FILES["file"]["name"]);
                $filenamefile = $OrgName . '_' . $getLastId . '.' . $request->file_type;
                $pathfile = public_path('/upload/teacher/general_information/' . $filenamefile);
                $pathfile = str_replace("main-laravel/public", "public_html", $pathfile);
                @move_uploaded_file($_FILES["file"]["tmp_name"], $pathfile);
            }
        } else {
            $filenamefile = null;
        }

        $request->request->add(['teacher_id' => $request->teacher_id]);
        $request->request->add(['school_id' => $request->school_id]);
        $request->request->add(['grade_id' => $request->grade_id]);
        $request->request->add(['base_id' => $request->base_id]);
        $request->request->add(['class_id' => $request->class_id]);
        $request->request->add(['lesson_id' => $request->lesson_id]);
        $request->request->add(['file_type' => $request->file_type]);
        $request->request->add(['file' => $filenamefile]);

        $GeneralInformation = GeneralInformation::create($request->all());;
        $GeneralInformation->update([
            'file' => $filenamefile,
        ]);
        return redirect()->back()->with('success',
            'فایل با موفقیت بارگذاری گردید.'
        )->withInput();
//
    }

    public function ClassList(Request $request)
    {
        $base_id = $request->base_id;
        $grade_id = $request->grade_id;
        $school_id = $request->school_id;

        $ClassList = ClassAssign::where('school_id', $school_id)
            ->where('grade_id', $grade_id)
            ->where('base_id', $base_id)
            ->get();
        if ($base_id) {
            $output = '<option value="0">انتخاب نشده</option>';

            foreach ($ClassList as $item) {
                $output .= '<option value="' . $item->id . '">' . $item->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }
        return $output;
    }

    public function LessonList(Request $request)
    {
        $base_id = $request->base_id;
        $grade_id = $request->grade_id;
        $List = Lesson::where('grade_id', $grade_id)
            ->where('base_id', $base_id)
            ->get();

        if ($base_id) {
            $output = '<option value="0">انتخاب نشده</option>';

            foreach ($List as $item) {
                $output .= '<option value="' . $item->id . '">' . $item->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }
        return $output;
    }

    public function Table(Request $request)
    {
        $school_id = $request->school_id;
        $teacher_id = $request->teacher_id;
        $grade_id = $request->grade_id;
        $base_id = $request->base_id;
        $lesson_id = $request->lesson_id;
        $class_id = $request->class_id;

        $tableResult = GeneralInformation::where('teacher_id', $teacher_id)
            ->where('school_id', $school_id)
            ->where('grade_id', $grade_id)
            ->where('base_id', $base_id)
            ->where('lesson_id', $lesson_id)
            ->get();


        $teacherSelect = Teacher::where('id', $teacher_id)
            ->first();

        $baseSelect = Base::where('id', $base_id)
            ->first();

        $classSelect = ClassAssign::where('id', $class_id)
            ->first();
        $lessonSelect = Lesson::where('id', $lesson_id)
            ->first();

        $output = '';
        if (!$tableResult->isEmpty()) {
            $output .= '
                <div class="card">
                    <div class="scrollbar-external_wrapper">
                        <div class="scrollbar-external">
                            <div class="table-">
                                <table class="table table-transparent mb0">
                                    <tbody>
                                    <tr style="text-align: center;background: #DBE5F4;">
                                            <th style="border: none"><div style="padding: 15px;">فهرست اطلاعات عمومی <b> پایه : </b> <b style="color: #39DA8A">' . $baseSelect->title . '</b> , <b> کلاس : </b> <b style="color: #39DA8A">' . $classSelect->title . '</b> , <b> درس : </b> <b style="color: #39DA8A">' . $lessonSelect->title . '</b></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="table-extended-chechbox" class="table table-transparent">
                                    <thead>
                                    <tr>
                                        <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                        <th>شناسه</th>
                                        <th>نوع</th>
                                        <th>نام فایل</th>
                                        <th>دانلود</th>
                                    </tr>
                                    </thead>
                                    <tbody>
            ';
            $row = 0;
            foreach ($tableResult as $item) {
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
                            <td>' . $item->file_type . '</td>
                            <td>' . $item->file . '</td>
                            <td>
                            <a href="' . asset('upload/teacher/general_information') . '/' . $item->file . '" download="download"><i class="bx bx-download"></i></a>
                            </td>
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
                    <img src="' . asset('Assets/Admin/images/noResult3.png') . '"
                         style="width: 200px;margin: 0 auto" alt="">
                    <p class="pt10">
                        آیتمی جهت نمایش وجود ندارد!
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
                            var _id = $(".stocks_list a").attr("rel");
                            var _token = $("#_token").val();
                            $(".lds-ripple-content").show();
                            $.ajax({
                                type: "POST",
                                url: "' . route('GeneralInformation.Delete') . '",
                                data: {_id: _id, _token: _token},
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
        $GeneralInfo = $request->_id;

//        GeneralInformation::where('id', $GeneralInfo)->delete();
        $output = '';
        $output .= '
            <script>
                $("#tr_' . $GeneralInfo . '").remove();
                $(".sweet-overlay").remove();
                $(".showSweetAlert").remove();
                $(".lds-ripple-content").hide();
                Command: toastr["success"]("فایل با موفقیت حذف گردید", "");
            </script>
        ';
        return $output;
    }
}
