<?php

namespace App\Modules\WeeklySchedule\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Schedule\Admin\Models\Schedule;
use App\Modules\WeeklySchedule\Admin\Models\WeeklySchedule;
use App\Modules\School\Admin\Models\School;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\TeacherAssign\Admin\Models\TeacherAssign;
use App\Modules\TrainingHours\Admin\Models\TrainingHours;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class WeeklyScheduleManager extends Controller
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

            $TrainingDays = TrainingHours::where('school_id', $SchoolSelect->id)
                ->groupBy('week_day')
                ->orderBy('week_day', 'asc')
                ->get();

            foreach ($TrainingDays as $item) {
                $TrainingHours[$item->id] = TrainingHours::where('week_day', $item->week_day)
                    ->where('school_id', $SchoolSelect->id)
                    ->orderBy('time_number', 'asc')
                    ->get();

                foreach ($TrainingHours[$item->id] as $item2) {
                    $Schedule[$item2->id] = Schedule::where('week_day', $item2->week_day)
                        ->where('time_number', $item2->time_number)
                        ->where('teacher_id', $teacherAdmin->id)
                        ->first();
                    if ($Schedule[$item2->id]) {
                        $classSelect[$item2->id] = ClassAssign::where('id' , $Schedule[$item2->id]->class_id)
                            ->first();

                        $teacher_assign[$item2->id] = TeacherAssign::where('teacher_id' , $Schedule[$item2->id]->teacher_id)
                            ->first();

                        $lessonSelect[$item2->id] = Lesson::where('id' , $Schedule[$item2->id]->lesson_id)
                            ->first();
                    } else {
                        $classSelect[$item2->id] = null;

                        $teacher_assign[$item2->id] = null;

                        $lessonSelect[$item2->id] = null;
                    }


                }
            }

            $WeekDayNumber = Jalalian::forge(now())->format('%u');
            $timeNow = Jalalian::forge(now())->format('H:i');


            return view($this->GetPreView() . 'Add', compact('teacherId', 'teacherAdmin', 'SchoolSelect', 'assignSelect', 'baseList', 'WeekDayNumber', 'timeNow', 'TrainingDays', 'TrainingHours', 'Schedule', 'classSelect', 'teacher_assign', 'lessonSelect'));
        } else {
            return redirect(route('TeacherLoginView'));
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


}
