<?php

namespace App\Modules\Students\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\StudentsRequest;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\Parents\Admin\Models\Parents;
use App\Modules\School\Admin\Models\School;
use App\Modules\Students\Admin\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsManager extends Controller
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
    public function Add(StudentsRequest $request)
    {
        $checkDoubleStudent = Students::where('national_code', $request->student_national_code)
            ->where('school_id', $request->school_id)
            ->first();
        if ($checkDoubleStudent) {
            return redirect()->back()->with('error',
                'دانش آموز، با کد ملی وارد شده برای این مرکز آموزش ثبت شده است!'
            )->withInput();
        } else {
            $created_at = date('Y-m-d H:i:s');
            if ($request->image) {
                if ($_FILES["image"]["size"] > 0) {
                    $image = $request->file('image');
                    $filenameimage = 'image' . time() . '_' . $_FILES["image"]["name"];
                    $pathfile = public_path('/upload/students/images/' . $filenameimage);
                    $pathfile = str_replace("main-laravel/public", "public_html", $pathfile);
                    @move_uploaded_file($_FILES["image"]["tmp_name"], $pathfile);
                }
            } else {
                $filenameimage = null;
            }
            $Students = Students::create(
                [
                    'name' => $request->student_name,
                    'family' => $request->student_family,
                    'phone' => $request->student_phone,
                    'code' => null,
                    'image' => $filenameimage,
                    'national_code' => $request->student_national_code,
                    'password' => bcrypt($request->student_password),
                    'school_id' => $request->school_id,
                    'deputy_id' => $request->deputy_id,
                    'grade_id' => $request->grade_id,
                    'base_id' => $request->base_id,
                    'class_id' => $request->class_id,
                    'email' => $request->student_email,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ]
            );
            Parents::create(
                [
                    'name' => $request->parents_name,
                    'family' => $request->parents_family,
                    'phone' => $request->parents_phone,
                    'code' => null,
                    'national_code' => $request->parents_national_code,
                    'student_id' => $Students->id,
                    'password' => bcrypt($request->parents_password),
                    'school_id' => $request->school_id,
                    'deputy_id' => $request->deputy_id,
                    'grade_id' => $request->grade_id,
                    'base_id' => $request->base_id,
                    'class_id' => $request->class_id,
                    'email' => $request->parents_email,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ]
            );
            return redirect()->back()->with('success',
                'افزودن دانش آموز و ولی انش آموز با موفقیت انجام شد.'
            )->withInput();
        }
    }

    //Return Edit Views
    public function EditView($id)
    {
        if (Auth::guard('deputy')->check() == true) {
            $id = Students::findOrFail($id);
            $parentsSelect = Parents::where('student_id', $id->id)
                ->first();
            $deputyId = Auth::guard('deputy')->id();
            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();
            $gradeSelect = Grade::where('id', $id->grade_id)
                ->first();
            $baseSelect = Base::where('id', $id->base_id)
                ->first();
            $classSelect = ClassAssign::where('id', $id->class_id)
                ->first();
            return view($this->GetPreView() . 'Edit', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'baseSelect', 'classSelect', 'parentsSelect', 'gradeSelect'))->with(['data' => $id]);
        } elseif (Auth::guard('students')->check() == true) {
            $id = Students::findOrFail($id);
            $deputyId = Auth::guard('students')->id();
            $parentsSelect = Parents::where('student_id', $deputyId)
                ->first();
            $studentsAdmin = Students::where('id', $deputyId)
                ->first();

            $deputyAdmin = Deputy::where('school_id', $studentsAdmin->school_id)
                ->first();

            $SchoolSelect = School::where('id', $studentsAdmin->school_id)
                ->first();

            $gradeSelect = Grade::where('id', $studentsAdmin->grade_id)
                ->first();

            $baseSelect = Base::where('id', $studentsAdmin->base_id)
                ->first();
            $classSelect = ClassAssign::where('id', $studentsAdmin->class_id)
                ->first();

            return view($this->GetPreView() . 'Edit', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'baseSelect', 'classSelect', 'parentsSelect', 'gradeSelect'))->with(['data' => $id]);
        } else {
            return redirect(route('DeputyLoginView'));
        }
    }

    //Edit Data
    public function Edit(StudentsRequest $request, $id)
    {
        $checkDoubleStudent = Students::where('national_code', $request->student_national_code)
            ->where('school_id', $request->school_id)
            ->where('id', '!=', $id)
            ->first();

        if ($checkDoubleStudent) {
            return redirect()->back()->with('error',
                'دانش آموز، با کد ملی وارد شده برای این مرکز آموزش ثبت شده است!'
            )->withInput();
        } else {
            $StudentSelect = Students::findOrFail($id);
            $ParentsSelect = Parents::where('student_id', $StudentSelect->id)
                ->where('school_id', $request->school_id)
                ->where('class_id', $request->class_id_edit)
                ->where('grade_id', $request->grade_id)
                ->where('base_id', $request->base_id_edit)
                ->first();


            $created_at = date('Y-m-d H:i:s');

            if ($request->uploadedImage) {

            } else {

            }
            if ($request->image) {
                if ($_FILES["image"]["size"] > 0) {
                    $image = $request->file('image');
                    $filenameimage = 'image' . time() . '_' . $_FILES["image"]["name"];
                    $pathfile = public_path('/upload/students/images/' . $filenameimage);
                    $pathfile = str_replace("main-laravel/public", "public_html", $pathfile);
                    @move_uploaded_file($_FILES["image"]["tmp_name"], $pathfile);
                }
            } elseif ($request->uploadedImage) {
                $filenameimage = $request->uploadedImage;
            } else {
                $filenameimage = null;
            }

            if ($request->student_password) {
                $StudentSelect->update([
                    'name' => $request->student_name,
                    'family' => $request->student_family,
                    'phone' => $request->student_phone,
                    'password' => bcrypt($request->student_password),
                    'email' => $request->student_email,
                    'image' => $filenameimage,
                    'updated_at' => $created_at,
                ]);
            } else {
                $StudentSelect->update([
                    'name' => $request->student_name,
                    'family' => $request->student_family,
                    'phone' => $request->student_phone,
                    'email' => $request->student_email,
                    'image' => $filenameimage,
                    'updated_at' => $created_at,
                ]);
            }
            if ($request->parents_password) {
                $ParentsSelect->update([
                    'name' => $request->parents_name,
                    'family' => $request->parents_family,
                    'phone' => $request->parents_phone,
                    'password' => bcrypt($request->parents_password),
                    'email' => $request->parents_email,
                    'updated_at' => $created_at,
                ]);
            } else {
                $ParentsSelect->update([
                    'name' => $request->parents_name,
                    'family' => $request->parents_family,
                    'phone' => $request->parents_phone,
                    'password' => bcrypt($request->parents_password),
                    'email' => $request->parents_email,
                    'updated_at' => $created_at,
                ]);
            }
            return redirect(route('Students.Add.View'))->with('success',
                'ویرایش دانش آموز و ولی دانش آموز با موفقیت انجام شد.'
            )->withInput();
        }
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

    public function Table(Request $request)
    {
        $class_id = $request->class_id;
        $base_id = $request->base_id;
        $grade_id = $request->grade_id;
        $deputy_id = $request->deputy_id;
        $school_id = $request->school_id;
        $student_id = $request->student_id;
        $deputyId = Auth::guard('deputy')->id();
        $deputyAdmin = Deputy::where('id', $deputyId)
            ->first();


        $studentsList = Students::where('school_id', $school_id)
            ->where('deputy_id', $deputy_id)
            ->where('grade_id', $grade_id)
            ->where('base_id', $base_id)
            ->where('class_id', $class_id)
            ->get();

        $baseSelect = Base::where('id', $base_id)
            ->first();
        $classSelect = ClassAssign::where('id', $class_id)
            ->first();
        $output = '';
        if (!$studentsList->isEmpty()) {
            if ($student_id) {
                $output .= '
                    <style>
                        #tr_' . $student_id . ' {
                            background: #DCDFE2;
                        }
                    </style>
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
                                        <th style="border: none"><div style="padding: 15px;"> <b>فهرست دانش آموزان پایه</b> <b style="color: #39DA8A"> ' . $baseSelect->title . ' </b> <b> , کلاس </b> <b style="color: #39DA8A"> ' . $classSelect->title . ' </b> </div></th>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="table-extended-chechbox" class="table table-transparent">
                                <thead>
                                <tr>
                                    <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                    <th>شناسه</th>
                                    <th>کد ملی</th>
                                    <th>نام و نام خانوادگی دانش آموز</th>
                                </tr>
                                </thead>
                                <tbody>
        ';
            if ($deputyAdmin->hasPermission('Students.Edit.View') || $deputyAdmin->level == "1") {
                foreach ($studentsList as $item) {
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
                        <td>' . $item['national_code'] . '</td>
                        <td>' . $item['name'] . ' ' . $item['family'] . '</td>
                    </tr>
            ';
                }
            } else {
                foreach ($studentsList as $item) {
                    $output .= '
                    <tr class="text-center" id="tr_' . $item['id'] . '">
                        <td>
                        </td>
                        <td class="text-bold-500">' . $item['id'] . '</td>
                        <td>' . $item['national_code'] . '</td>
                        <td>' . $item['name'] . ' ' . $item['family'] . '</td>
                    </tr>
            ';
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

        $output .= '
            <script>
                $("input[type=radio][name=edit]").change(function () {
                    var url = "' . route("Students.Edit", ":id") . '";
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

    public function DeleteImage(Request $request)
    {
        $_id = $request->_id;
        if ($_id) {
            $selectStudent = Students::findOrFail($_id);
            $selectStudent->update([
                'image' => null,
            ]);
        }
    }
}
