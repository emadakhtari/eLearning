<?php

namespace App\Modules\Schedule\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\ScheduleRequest;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Schedule\Admin\Models\Schedule;
use App\Modules\School\Admin\Models\School;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\TeacherAssign\Admin\Models\TeacherAssign;
use App\Modules\TrainingHours\Admin\Models\TrainingHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleManager extends Controller
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
            $baseList = Base::where('grade_id', $assignSelect->grade_id)
                ->get();

            return view($this->GetPreView() . 'Add', compact('deputyId', 'deputyAdmin', 'SchoolSelect', 'assignSelect', 'baseList'));
        } else {
            return redirect(route('DeputyLoginView'));
        }
    }

    //Add Data
    public function Add(ScheduleRequest $request)
    {


        $chechTeacher = Schedule::where('teacher_id', $request->teacher_id)
            ->where('class_id', $request->class_id)
            ->where('lesson_id', $request->lesson_id)
            ->first();
        if ($chechTeacher) {
            $chechTeacher->delete();
        }
        $row = 0;
        if ($request->week) {
            $created_at = date('Y-m-d H:i:s');
            foreach ($request->week as $item) {
                $pieces[$row] = explode("**", $item);
                $week_day = $pieces[$row][0];
                $time_number = $pieces[$row][1];

                $selectClass[$row] = Schedule::where('deputy_id', $request->deputy_id)
                    ->where('base_id', $request->base_id)
                    ->where('class_id', $request->class_id)
                    ->where('lesson_id', $request->lesson_id)
                    ->where('teacher_id', $request->teacher_id)
                    ->where('week_day', $week_day)
                    ->where('time_number', $time_number)
                    ->first();

                $trainingHours[$row] = TrainingHours::where('week_day', $pieces[$row][0])
                    ->where('time_number', $pieces[$row][1])
                    ->first();

                if (!$selectClass[$row]) {
                    Schedule::create(
                        [
                            'school_id' => $request->school_id,
                            'deputy_id' => $request->deputy_id,
                            'grade_id' => $request->grade_id,
                            'base_id' => $request->base_id,
                            'class_id' => $request->class_id,
                            'lesson_id' => $request->lesson_id,
                            'teacher_id' => $request->teacher_id,
                            'week_day' => $pieces[$row][0],
                            'time_number' => $pieces[$row][1],
                            'start_time' => $trainingHours[$row]->start_time,
                            'end_time' => $trainingHours[$row]->end_time,
                            'created_at' => $created_at,
                            'updated_at' => $created_at
                        ]
                    );
                }
                $row++;
            }
            return redirect()->back()->with('success',
                'برنامه آموزشی با موفقیت انجام شد.'
            )->withInput();
        } else {
            return redirect()->back()->with('error',
                'لطفا برنامه های آموزشی را انتخاب نمایید.'
            )->withInput();
        }
    }

    public function LessonList(Request $request)
    {
        $school_id = $request->school_id;
        $grade_id = $request->grade_id;
        $base_id = $request->base_id;

        $lessonList = TeacherAssign::where('base_id', $base_id)
            ->where('school_id', $school_id)
            ->get();
        if ($lessonList) {
            $output = '<option value="">انتخاب نشده</option>';
            foreach ($lessonList as $item) {
                $lessonSelect = Lesson::where("id", $item->lesson_id)
                    ->first();

                $output .= '<option value="' . $lessonSelect->id . '">' . $lessonSelect->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }
        return $output;
    }

    public function ClassList(Request $request)
    {
        $school_id = $request->school_id;
        $base_id = $request->base_id;
        $lesson_id = $request->lesson_id;
        $classList = TeacherAssign::where('base_id', $base_id)
            ->where('school_id', $school_id)
            ->where('lesson_id', $lesson_id)
            ->get();

        if ($base_id) {
            $output = '<option value="">انتخاب نشده</option>';
            foreach ($classList as $item) {
                $classSelect = ClassAssign::where("id", $item->class_id)
                    ->first();
                $output .= '<option value="' . $classSelect->id . '">' . $classSelect->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }

        return $output;
    }

    public function TeacherList(Request $request)
    {
        $school_id = $request->school_id;
        $base_id = $request->base_id;
        $lesson_id = $request->lesson_id;
        $class_id = $request->class_id;
        $teacherList = TeacherAssign::where('school_id', $school_id)
            ->where('base_id', $base_id)
            ->where('lesson_id', $lesson_id)
            ->where('class_id', $class_id)
            ->get();

        if ($teacherList) {
            $output = '<option value="">انتخاب نشده</option>';
            foreach ($teacherList as $item) {
                $teacherSelect = Teacher::where('id', $item->teacher_id)
                    ->first();
                $output .= '<option value="' . $teacherSelect->id . '">' . $teacherSelect->name . ' ' . $teacherSelect->family . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';

        }
        return $output;
    }

    public function weekTable(Request $request)
    {
        $deputy_id = $request->deputy_id;
        $base_id = $request->base_id;
        $school_id = $request->school_id;
        $lesson_id = $request->lesson_id;
        $class_id = $request->class_id;
        $teacher_id = $request->teacher_id;
        $output = "";

        $trainingHoursList = TrainingHours::where('school_id', $school_id)
            ->where('deputy_id', $deputy_id)
            ->select('week_day')
            ->orderBy('week_day', 'asc')
            ->distinct()->get();

        if (!$trainingHoursList->isEmpty()) {
            $row = 0;
            foreach ($trainingHoursList as $item) {
                $timenumbers[$row] = TrainingHours::where('week_day', $item->week_day)
                    ->where('deputy_id', $deputy_id)
                    ->get();
                $row++;
            }
        } else {
            $timenumbers = null;
        }

        $row = 0;
        foreach ($trainingHoursList as $item) {
            if ($item->week_day == '1') {
                $week_day = "شنبه";
            } elseif ($item->week_day == '2') {
                $week_day = "یک شنبه";
            } elseif ($item->week_day == '3') {
                $week_day = "دو شنبه";
            } elseif ($item->week_day == '4') {
                $week_day = "سه شنبه";
            } elseif ($item->week_day == '5') {
                $week_day = "چهار شنبه";
            } elseif ($item->week_day == '6') {
                $week_day = "پنج شنبه";
            } elseif ($item->week_day == '7') {
                $week_day = "جمعه";
            }
            $output .= '
    <script type="text/javascript"
            src="'.asset('Assets/Admin/js/scripts/popover/popover.js').'"></script>
                    <section class="plan cf">
                    <span class="weekDay">
                        ' . $week_day . '
                    </span>
            ';
            foreach ($timenumbers[$row] as $item2) {
                $selectClass = Schedule::where('deputy_id', $deputy_id)
                    ->where('base_id', $base_id)
                    ->where('class_id', $class_id)
                    ->where('lesson_id', $lesson_id)
                    ->where('teacher_id', $teacher_id)
                    ->where('week_day', $item2->week_day)
                    ->where('time_number', $item2->time_number)
                    ->first();
                if ($selectClass) {
                    $selected = ' checked';
                } else {
                    $selected = '';
                }

                $output .= '
                    <span class="spanWeek">
                        <input type="checkbox" name="week[' . $item->week_day . '_' . $item2->id . ']"
                               ' . $selected . '
                               id="free' . $item2->id . '"
                               value="' . $item->week_day . '**' . $item2->time_number . '"
                               class="radioWeek"><label
                                class="free-label four col"
                                for="free' . $item2->id . '" data-toggle="popover"
                                data-original-title="از ساعت ' . $item2->start_time . '"
                                data-content="تا ساعت ' . $item2->end_time . '"
                                data-trigger="hover"
                                data-placement="top">' . $item2->time_number . '</label>
                    </span>
            ';
            }
            $row++;
            $output .= '
                </section>
                <div class="clear"></div>
            ';
        }

        if (!$trainingHoursList->isEmpty()) {
            $success = '2';
        } else {
            $success = '1';
        }
        return response()->json(
            [
                'success' => $success,
                'output' => $output
            ]
        );

    }
}
