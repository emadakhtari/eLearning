<?php

namespace App\Modules\Teacher\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\TeacherRequest;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\School\Admin\Models\School;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherManager extends Controller
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
            $Teacher = Teacher::where('school_id' , $SchoolSelect)
            ->get();
            return view($this->GetPreView() . 'Add', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'Teacher'));
        } else {
            return redirect(route('DeputyLoginView'));
        }

    }

    //Add Data
    public function Add(TeacherRequest $request)
    {
        $checkTeacher =Teacher::where('national_code' , $request->national_code )
            ->where('school_id' , $request->school_id )
            ->first();
        if ($checkTeacher) {
            return redirect()->back()->with('error',
                'مدرس، با کد ملی وارد شده برای این مرکز آموزش ثبت شده است!'
            )->withInput();
        } else {
            $request->request->add(['password' => bcrypt($request->password)]);
            Teacher::create($request->all());
            return redirect()->back()->with('success',
                'افزودن مدرس با موفقیت انجام شد.'
            )->withInput();
        }
    }

    //Return Edit Views
    public function EditView($id)
    {

        if (Auth::guard('deputy')->check() == true) {
            $id = Teacher::findOrFail($id);
            $deputyId = Auth::guard('deputy')->id();
            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();
            $Teacher = Teacher::where('school_id' , $SchoolSelect)
                ->get();
            return view($this->GetPreView() . 'Edit', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'Teacher'))->with(['data' => $id]);
        } elseif(Auth::guard('teacher')->check() == true) {
            $id = Teacher::findOrFail($id);
            $deputyId = Auth::guard('teacher')->id();
            $deputyAdmin = Teacher::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();
            $Teacher = Teacher::where('school_id' , $SchoolSelect)
                ->get();
            return view($this->GetPreView() . 'Edit', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'Teacher'))->with(['data' => $id]);
        } else {
            return redirect(route('DeputyLoginView'));
        }
    }

    //Edit Data
    public function Edit(TeacherRequest $request, $id)
    {
        $checkTeacher =Teacher::where('national_code' , $request->national_code )
            ->where('school_id' , $request->school_id )
            ->where('id' ,'!=', $request->teacher_id )
            ->first();
        if ($checkTeacher) {
            return redirect()->back()->with('error',
                'مدرس، با کد ملی وارد شده برای این مرکز آموزش ثبت شده است!'
            )->withInput();
        } else {
            $Teacher = Teacher::findOrFail($id);
            if ($request->password) {
                $request->merge(['password' => bcrypt($request->password)]);
                $Teacher->update($request->all());
            } else {
                $image_fields = $request->except('password');
                $Teacher->update($image_fields);
            }
            return redirect(route('Teacher.Add.View'))->with('success',
                'ویرایش مدرس با موفقیت انجام شد.'
            )->withInput();
        }
    }

    //Table
    public function Table(Request $request)
    {
        $school_id = $request->school_id;
        $deputy_id = $request->deputy_id;
        $teacher_id = $request->teacher_id;
        $Teacher = Teacher::where('school_id', $school_id)
            ->get();

        $deputyId = Auth::guard('deputy')->id();
        $deputyAdmin = Deputy::where('id', $deputyId)
            ->first();

        $output = '
                    <style>
                        #tr_'.$teacher_id.' {
                            background: #DCDFE2;
                        }
                    </style>
        ';
        if (!$Teacher->isEmpty()) {
            if ($teacher_id) {
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
                                        <th style="border: none"><div style="padding: 15px;"><b>فهرست مدرسین مرکز آموزش</b> </div></th>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="table-extended-chechbox" class="table table-transparent">
                                <thead>
                                <tr>
                                    <th style="width: 24px !important;"><i class="bx bx-x"></i></th>
                                    <th>شناسه</th>
                                    <th>نام و نام خانوادگی مدرس</th>
                                    <th>کد ملی</th>
                                </tr>
                                </thead>
                                <tbody>
        ';
            if ($deputyAdmin->hasPermission('Teacher.Edit.View') || $deputyAdmin->level == "1") {
                foreach ($Teacher as $item) {
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
            } else {
                foreach ($Teacher as $item) {
                    $output .= '
                    <tr class="text-center" id="tr_'.$item['id'].'">
                        <td>
                        </td>
                        <td class="text-bold-500">'.$item['id'].'</td>
                        <td>'.$item['name'].' '.$item['family'].'</td>
                        <td>'.$item['national_code'].'</td>
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
                <img src="'.asset('Assets/Admin/images/noResult3.png').'"
                     style="width: 200px;margin: 0 auto" alt="">
                <p class="pt10">
                    آیتمی جهت نمایش وجود ندارد!
                </p>
            </div>
        ';
        }

        $output .='
            <script>
                $("input[type=radio][name=edit]").change(function () {
                    var url = "'.route("Teacher.Edit", ":id").'";
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


}
