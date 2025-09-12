<?php

namespace App\Modules\ClassRoom\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\ClassesCompleted\Admin\Models\ClassesCompleted;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Schedule\Admin\Models\Schedule;
use App\Modules\Students\Admin\Models\Students;
use App\Modules\StudentsAbsentPresent\Admin\Models\StudentsAbsentPresent;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

class ClassRoomManager extends Controller
{

    public function ShowView($id)
    {


        if (Auth::guard('teacher')->check() == true) {

            $id = Schedule::findOrFail($id);

            $teacherId = Auth::guard('teacher')->id();
            $teacher = Teacher::where('id', $teacherId)
                ->first();
            $class = ClassAssign::where('id', $id->class_id)
                ->first();
            $lesson = Lesson::where('id', $id->lesson_id)
                ->first();

            $meetingName = $class->title . "_" . $lesson->title;

            $check = \Bigbluebutton::server('server1')->all();

            if (!$check->isEmpty()) {
                foreach ($check as $item) {
                    if ($item['meetingID'] == $id->teacher_id . '_' . $id->id) {
                        $mnt = $item['meetingID'];
                        $moderatorPW = $item['moderatorPW'];
                        $attendeePW = $item['attendeePW'];
                    } else {
                        $mnt = null;
                        $moderatorPW = null;
                        $attendeePW = null;
                    }
                }
            } else {
                $mnt = null;
                $moderatorPW = null;
                $attendeePW = null;
            }


            if ($mnt == null) {
                $url = null;
            } else {
                $url = \Bigbluebutton::server('server1')->start([
                    'meetingID' => $mnt,
                    'meetingName' => $meetingName,
                    'moderatorPW' => $moderatorPW,
                    'attendeePW' => $attendeePW, //attendee password here
                    'userName' => $teacher->name . " " . $teacher->family,
                ]);
            }

            $MeetingInfo = \Bigbluebutton::server('server1')->getMeetingInfo([
                'meetingID' => $id->teacher_id . '_' . $id->id,
            ]);

            $isMeetingRunning = \Bigbluebutton::server('server1')->isMeetingRunning([
                'meetingID' => $id->teacher_id . '_' . $id->id,
            ]);

            $studentList = Students::where('school_id', $id->school_id)
                ->where('grade_id', $id->grade_id)
                ->where('base_id', $id->base_id)
                ->where('class_id', $id->class_id)
                ->get();


            return view($this->GetPreView() . 'Show', compact('teacherId', 'MeetingInfo', 'isMeetingRunning', 'url', 'id', 'check', 'studentList'));

        } else {
            return redirect(route('TeacherLoginView'));
        }
    }

    //Return Edit Views

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

    public function ClassRoomCreate(Request $request)
    {
        $class = ClassAssign::where('id', $request->class_id)
            ->first();

        $lesson = Lesson::where('id', $request->lesson_id)
            ->first();

        $meetingName = $class->title . "_" . $lesson->title;

        \Bigbluebutton::server('server1')->create([
            'meetingID' => $request->teacher_id . '_' . $request->page_id,
            'meetingName' => $meetingName,
        ]);
    }

    public function ClassRoomStart(Request $request)
    {
        $teacher = Teacher::where('id', $request->teacher_id)
            ->first();
        $class = ClassAssign::where('id', $request->class_id)
            ->first();

        $lesson = Lesson::where('id', $request->lesson_id)
            ->first();

        $meetingName = $class->title . "_" . $lesson->title;

        $url = \Bigbluebutton::server('server1')->start([
            'meetingID' => $request->teacher_id . '_' . $request->page_id,
            'meetingName' => $meetingName,
            'moderatorPW' => $request->teacher_id,
            'attendeePW' => $request->page_id, //attendee password here
            'userName' => $teacher->name . " " . $teacher->family,
            //'redirect' => false // only want to create and meeting and get join url then use this parameter
        ]);
//
//        $output = '<iframe src="' . $url . '"></iframe>';
        $output = '';

        return $output;
    }

    public function ClassRoomEnd(Request $request)
    {
        $teacher = Teacher::where('id', $request->teacher_id)
            ->first();
        $class = ClassAssign::where('id', $request->class_id)
            ->first();

        $lesson = Lesson::where('id', $request->lesson_id)
            ->first();
        $meetingName = $class->title . "_" . $lesson->title;
        $meetingID = $request->teacher_id . '_' . $request->page_id;

        $MeetingInfo = \Bigbluebutton::server('server1')->getMeetingInfo([
            'meetingID' => $meetingID,
        ]);
        \Bigbluebutton::server('server1')->close([
            'meetingID' => $meetingID,
            'moderatorPW' => $MeetingInfo['moderatorPW']
        ]);
        $output = '';
        return $output;
    }

    public function DelayHaste(Request $request)
    {
        $t = Carbon::now();
        $date = $t->toDateString();
        $checkClassHeld = ClassesCompleted::where('schedule_id', $request->page_id)
            ->where('holding_date', $date)
            ->first();

        if ($checkClassHeld) {
            $status = '0';
            $massage = 'گزارش حضور و غیاب برای این کلاس انجام شده است.';
        } else {
            $created_at = date('Y-m-d H:i:s');
            $class = new ClassesCompleted();
            $class->schedule_id = $request->page_id;
            $class->holding_date = $date;
            $class->holding_time = $created_at;
            $class->save();

            foreach ($request->studentid as $student) {
                if (isset($request->status[$student])) {
                    $status = '1';
                } else {
                    $status = '0';
                }
                $AbsentPresent = new StudentsAbsentPresent();
                $AbsentPresent->classes_completed_id = $class->id;
                $AbsentPresent->student_id = $student;
                $AbsentPresent->delay = $request->delay[$student];
                $AbsentPresent->haste = $request->haste[$student];
                $AbsentPresent->status = $status;
                $AbsentPresent->save();
            }

            $status = '1';
            $massage = 'گزارش حضور و غیاب قبلا برای این کلاس با موفقیت انجام شد.';
        }

        return response()->json(
            [
                'status' => $status,
                'massage' => $massage,
            ]
        );
    }

}
