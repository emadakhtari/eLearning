<?php

namespace App\Modules\TrainingInformation\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Schedule\Admin\Models\Schedule;
use App\Modules\School\Admin\Models\School;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\TrainingInformation\Admin\Models\TrainingInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class TrainingInformationManager extends Controller
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

            $WeekDayNumber = Jalalian::forge(now())->format('%u');

            $timeNow = Jalalian::forge(now())->format('H:i');

            $schedule = Schedule::where('teacher_id' , $teacherId)
                ->get();

            $row = 0;
            $row1 = 0;
            foreach ($schedule as $item) {
                if ($item->week_day == '1') {
                    $toDateString[$row] = Carbon::now()
                        ->next(6)
                        ->toDateString();
                } elseif ($item->week_day == '2') {
                    $toDateString[$row] = Carbon::now()
                        ->next(0)
                        ->toDateString();
                } elseif ($item->week_day == '3') {
                    $toDateString[$row] = Carbon::now()
                        ->next(1)
                        ->toDateString();
                } elseif ($item->week_day == '4') {
                    $toDateString[$row] = Carbon::now()
                        ->next(2)
                        ->toDateString();
                } elseif ($item->week_day == '5') {
                    $toDateString[$row] = Carbon::now()
                        ->next(3)
                        ->toDateString();
                } elseif ($item->week_day == '6') {
                    $toDateString[$row] = Carbon::now()
                        ->next(4)
                        ->toDateString();
                } elseif ($item->week_day == '7') {
                    $toDateString[$row] = Carbon::now()
                        ->next(5)
                        ->toDateString();
                } else {
                    $toDateString[$row] =null;
                }
                for($x = 0; $x <= 365; $x+=7) {
                    $addDays[$row1] =  Carbon::parse($toDateString[$row])
                        ->addDays($x)
                        ->format('Y-m-d H:i:s');
                    $row1++;
                }

                $row++;
            }

            return view($this->GetPreView() . 'Add', compact('teacherId', 'teacherAdmin', 'SchoolSelect', 'assignSelect', 'baseList', 'WeekDayNumber', 'timeNow', 'schedule', 'toDateString', 'addDays'));
        } else {
            return redirect(route('TeacherLoginView'));
        }
    }

    public function AddTrain(Request $request)
    {
        if ($request->file) {
            if ($_FILES["file"]["size"] > 0) {
                $file = $request->file('file');
                $filenamefile = 'file' . time() . '_' . $_FILES["file"]["name"];
                $pathfile = public_path('/upload/teacher/training_information/' . $filenamefile);
                $pathfile = str_replace("main-laravel/public", "public_html", $pathfile);
                @move_uploaded_file($_FILES["file"]["tmp_name"], $pathfile);
            }
        } else {
            $filenamefile = null;
        }

        $request->request->add(['title' => $request->title]);
        $request->request->add(['teacher_id' => $request->teacher_id]);
        $request->request->add(['school_id' => $request->school_id]);
        $request->request->add(['grade_id' => $request->grade_id]);
        $request->request->add(['base_id' => $request->base_id]);
        $request->request->add(['class_id' => $request->class_id]);
        $request->request->add(['date' => $request->date]);
        $request->request->add(['file_type' => $request->file_type]);

        $request->request->add(['file' => $filenamefile]);

        $TrainingInformation = TrainingInformation::create($request->all());;
        $TrainingInformation->update([
            'file' => $filenamefile,
        ]);
//
    }


    public function Table(Request $request)
    {

        $school_id = $request->school_id;
        $teacher_id = $request->teacher_id;
        $grade_id = $request->grade_id;

        $TeacherAssign = TrainingInformation::where('teacher_id', $teacher_id)
            ->where('school_id', $school_id)
            ->where('grade_id', $grade_id)
            ->get();


        $teacherSelect = Teacher::where('id', $teacher_id)
            ->first();


        $output = '';
            if (!$TeacherAssign->isEmpty()) {
                $output .= '
                <div class="card">
                    <div class="scrollbar-external_wrapper">
                        <div class="scrollbar-external">
                            <div class="table-">
                                <table class="table table-transparent mb0">
                                    <tbody>
                                        <tr style="text-align: center;background: #DBE5F4;">
                                            <th style="border: none"><div style="padding: 15px;"><b>فهرست اطلاعات ساعات آموزشی  </b></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="table-extended-chechbox" class="table table-transparent">
                                    <thead>
                                    <tr>
                                        <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                        <th>پایه - کلاس</th>
                                        <th>نوع</th>
                                        <th>عنوان <i style="position: relative;top: 3px;" class="bx bx-download"></i></th>
                                        <th>مربوط به تاریخ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
            ';
                $row = 0;
                foreach ($TeacherAssign as $item) {
                    $baseSelect = Base::where('id', $item['base_id'])
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
                            <td>' . $baseSelect->title . ' - ' . $classSelect->title . '</td>
                            <td>' .  $item['file_type'] . '</td>
                            <td>
                             <a download href="'.asset('upload/teacher/training_information').'/'.$item['file'].'">' .  $item['title'] . '</a>
                            </td>
                            <td>' .  \Morilog\Jalali\Jalalian::forge($item['date'])->format('%d %B %Y') . '</td>
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
                            var trainingInfo = $(".stocks_list a").attr("rel");
                            var _token = $("#_token").val();
                            $(".lds-ripple-content").show();
                            $.ajax({
                                type: "POST",
                                url: "' . route('TrainingInformation.Delete') . '",
                                data: {trainingInfo: trainingInfo, _token: _token},
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
                    "targets": [0,1,2,3,4]
                }, //to disable sortying in col 0,3 & 4
                ],
                "select": "multi",
                "order": [

                ]
            });
        </script>
        ';
        return $output;
    }
    public function Delete(Request $request)
    {
        $trainingInfo = $request->trainingInfo;
        TrainingInformation::where('id', $trainingInfo)->delete();
        $output = '';
        $output .= '
            <script>
                $("#tr_' . $trainingInfo . '").remove();
                $(".sweet-overlay").remove();
                $(".showSweetAlert").remove();
                $(".lds-ripple-content").hide();
                Command: toastr["success"]("اطلاعات با موفقیت حذف گردید", "");
            </script>
        ';
        return $output;
    }
}
