<?php

namespace App\Modules\TrainingHours\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\TrainingHoursRequest;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\School\Admin\Models\School;
use App\Modules\TrainingHours\Admin\Models\TrainingHours;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class TrainingHoursManager extends Controller
{
    public function AddView()
    {
        if (Auth::guard('deputy')->check() == true) {
            $deputyId = Auth::guard('deputy')->id();
            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();

            return view($this->GetPreView() . 'Add', compact('deputyId', 'deputyAdmin', 'SchoolSelect'));
        } else {
            return redirect(route('DeputyLoginView'));
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

    public function Add(TrainingHoursRequest $request)
    {
        $deputy_id = $request->deputy_id;
        $time_number = $request->time_number;
        $school_id = $request->school_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $week_day = $request->week_day;
        $created_at = date('Y-m-d H:i:s');

        if ($week_day) {
            foreach ($week_day as $item) {
                if ($item == "1") {
                    $dayName = "شنبه";
                } elseif ($item == "2") {
                    $dayName = "یک شنبه";
                } elseif ($item == "3") {
                    $dayName = "دو شنبه";
                } elseif ($item == "4") {
                    $dayName = "سه شنبه";
                } elseif ($item == "5") {
                    $dayName = "چهار شنبه";
                } elseif ($item == "6") {
                    $dayName = "پنج شنبه";
                } elseif ($item == "7") {
                    $dayName = "جمعه";
                } else {
                    $dayName = "";
                }
                $TrainingHoursCheckDouble[$item] = TrainingHours::where('deputy_id', $deputy_id)
                    ->where('week_day', $item)
                    ->where('time_number', $time_number)
                    ->first();
                if ($TrainingHoursCheckDouble[$item]) {
                    Session::flash('error' . $item . '', 'در روز ' . $dayName . ' برای شماره وقت ' . $time_number . ' ساعت انتخاب شده است ');
                } else {
                    Session::flash('message' . $item . '', 'ساعت آموزشی برای روز ' . $dayName . ' برای شماره وقت ' . $time_number . ' با موفقیت ثبت شد.');
                    TrainingHours::create(
                        [
                            'school_id' => $school_id,
                            'deputy_id' => $deputy_id,
                            'week_day' => $item,
                            'time_number' => $time_number,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'created_at' => $created_at,
                            'updated_at' => $created_at,
                        ]
                    );
                }
            }

        } else {
            Session::flash('error', 'لطفا روز هفته مورد نظر را انتخاب نمایید');
        }

        return redirect()->back();

    }

    public function EditView($id)
    {
        if (Auth::guard('deputy')->check() == true) {
            $id = TrainingHours::findOrFail($id);

            $deputyId = Auth::guard('deputy')->id();

            $deputyAdmin = Deputy::where('id', $deputyId)
                ->first();
            $SchoolSelect = School::where('id', $deputyAdmin->school_id)
                ->first();

            return view($this->GetPreView() . 'Edit', compact('deputyId', 'deputyAdmin', 'SchoolSelect'))->with(['data' => $id]);
        } else {
            return redirect(route('UsersLoginView'));
        }
    }

    //Edit Data
    public function Edit(TrainingHoursRequest $request, $id)
    {
        $deputy_id = $request->deputy_id;
        $week_day = $request->week_day;
        $time_number = $request->time_number;

        $TrainingHoursCheckDouble = TrainingHours::where('deputy_id', $deputy_id)
            ->where('week_day', $week_day)
            ->where('time_number', $time_number)
            ->where('id', '!=', $id)
            ->first();

        if ($TrainingHoursCheckDouble) {
            return redirect()->back()->with('error',
                'شماره وقت در این روز هفته قبلا برای شما انتخاب شده است!'
            )->withInput();
        } else {
            $TrainingHours = TrainingHours::findOrFail($id);
            $TrainingHours->update($request->all());
            return redirect(route('TrainingHours.Add.View'))->with('success',
                'ویرایش ساعت آموزشی با موفقیت انجام شد.'
            )->withInput();
        }

    }


    public function Table(Request $request)
    {

        $TrainingHoursId = $request->TrainingHoursId;


        $week_day = explode(',', $request->week_day);
        $deputyId = Auth::guard('deputy')->id();
        $deputyAdmin = Deputy::where('id', $deputyId)
            ->first();
        $output = '';

        if ($TrainingHoursId) {
            $output = '
                    <style>
                        #tr_' . $TrainingHoursId . ' {
                            background: #DCDFE2;
                        }
                    </style>

        ';
        } else {
            $output = '';
        }


        $week_row = 0;
        if ($week_day) {
            foreach ($week_day as $item) {
                $TrainingHours[$item] = TrainingHours::where('week_day', $item)
                    ->where('deputy_id', $deputyId)
                    ->get();
                if ($item) {
                    if (!$TrainingHours[$item]->isEmpty()) {
                        if ($TrainingHoursId) {
                            $output .= '
                    <script>
                    $(".fieldset' . $item . '").remove()
                    $(".bx-x' . $item . '").remove()
                    </script>

                    ';
                        }
                        if ($item == 1) {
                            $weekday = 'شنبه';
                        } elseif ($item == 2) {
                            $weekday = 'یک شنبه';
                        } elseif ($item == 3) {
                            $weekday = 'دو شنبه';
                        } elseif ($item == 4) {
                            $weekday = 'سه شنبه';
                        } elseif ($item == 5) {
                            $weekday = 'چهار شنبه';
                        } elseif ($item == 6) {
                            $weekday = 'پنج شنبه';
                        } elseif ($item == 7) {
                            $weekday = 'جمعه';
                        }
                        $output .= '
                <div class="card">
                    <div class="scrollbar-external_wrapper">
                        <div class="scrollbar-external">
                            <div class="table-">
                                <table class="table table-transparent mb0">
                                    <tbody>
                                        <tr style="text-align: center;background: #DBE5F4;">
                                            <th style="border: none"><div style="padding: 15px;"><b>فهرست ساعات آموزشی روز   : </b> <b style="color: #39DA8A">' . $weekday . '</b> <b> هر هفته</b> </div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="table-extended-chechbox' . $item . '" class="table table-transparent">
                                    <thead>
                                    <tr>
                                        <th style="width: 24px !important;"><i class="bx bx-x bx-x' . $item . '"></i></th>
                                        <th>شماره وقت</th>
                                        <th>ساعت شروع</th>
                                        <th>ساعت اختتام</th>
                                    </tr>
                                    </thead>
                                    <tbody>
            ';
                        $row = 0;
                        if ($deputyAdmin->hasPermission('TrainingHours.Edit.View') || $deputyAdmin->level == "1") {
                            foreach ($TrainingHours[$item] as $item_2) {
                                $output .= '
                        <tr class="text-center" id="tr_' . $item_2['id'] . '">
                            <td>

                                <fieldset class="fieldset fieldset' . $item . '">
                                    <div class="radio radio-shadow">
                                        <input type="radio" class="radioshadow radioshadow' . $item . '"
                                               id="radioshadow' . $item_2['id'] . '"
                                               name="edit"
                                               value="' . $item_2['id'] . '">
                                        <label for="radioshadow' . $item_2['id'] . '"></label>
                                    </div>
                                </fieldset>
                            </td>
                            <td>' . $item_2['time_number'] . '</td>
                            <td>' . $item_2['start_time'] . '</td>
                            <td>' . $item_2['end_time'] . '</td>
                        </tr>
                ';
                                $row++;
                            }
                        } else {
                            foreach ($TrainingHours[$item] as $item_2) {
                                $output .= '
                        <tr class="text-center" id="tr_' . $item_2['id'] . '">
                            <td>
                            </td>
                            <td>' . $item_2['time_number'] . '</td>
                            <td>' . $item_2['start_time'] . '</td>
                            <td>' . $item_2['end_time'] . '</td>
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
        <div class="col-md-12 col-12 stocks_list stocks_list' . $item . ' " style="text-align: right !important;">
        </div>
        <script>
                $(".radioshadow' . $item . '").change(function () {
                        $(".stocks_list a").remove();

                        var url = "' . route("TrainingHours.Edit", ":id") . '";
                        url = url.replace(":id", this.value);
                        $(".stocks_list' . $item . ' a").remove();
                        $(".stocks_list' . $item . '").append("<a>ویرایش</a>");
                        $(".stocks_list' . $item . ' a").addClass("btn btn-primary mr-1 mb-1 edit-btn float-none edit-btn' . $item . ' ");
                        $(".stocks_list' . $item . ' a").attr("href" , url);
                });

                $(".radioshadow' . $item . '").click(function () {
                 $(".bx-x").css("display", "none");
                        var inputValue = $(this).attr("value");
                        var targetBox = $("." + inputValue);
                        $(".bx-x' . $item . '").not(targetBox).css("display", "block");
                        $(".edit-btn' . $item . '").not(targetBox).css("display", "block");
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
            var tablecheckbox = $("#table-extended-chechbox' . $item . '").DataTable({
                "searching": false,
                "lengthChange": false,
                "paging": false,
                "bInfo": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0,1,2,3,4]
                }, //to disable sortying in col 0,3 & 4
                ],
                "select": "multi",
                "order": [
                    [1, "desc"]
                ]
            });
        </script>
                ';
                    }
                }
            }
        } else {
            $output .= '';
        }

        if ($output == "") {
            $output = '
                        <div class="text-center">
                            <img src="' . asset('Assets/Admin/images/noResult3.png') . '"
                                 style="width: 200px;margin: 0 auto" alt="">
                            <p class="pt10">
                                روز های هفته مورد نظر را ساعات آموزشی تعریف نشده است
                            </p>
                        </div>
                    ';
        }


        return $output;
    }

}
