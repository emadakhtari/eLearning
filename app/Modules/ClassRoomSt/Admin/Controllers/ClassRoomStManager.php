<?php

namespace App\Modules\ClassRoomSt\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Schedule\Admin\Models\Schedule;
use App\Modules\Students\Admin\Models\Students;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\TeacherAssign\Admin\Models\TeacherAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRoomStManager extends Controller
{

    public function ShowView($id)
    {


        if (Auth::guard('students')->check() == true) {

            $id = Schedule::findOrFail($id);

            $studentsId = Auth::guard('students')->id();

            $student = Students::where('id', $studentsId)
                ->first();

            $TeacherSelect = Teacher::where('id', $id->teacher_id)
                ->first();
            $teacherId = $id->teacher_id;
            $class = ClassAssign::where('id', $id->class_id)
                ->first();




            $lesson = Lesson::where('id', $id->lesson_id)
                ->first();

            $meetingName = $class->title . "_" . $lesson->title;



//            \Bigbluebutton::server('server1')->close([
//                'meetingID' => $id->teacher_id.'_'.$id->id,
//                'moderatorPW' => 'rgkHgmcx' //moderator password set here
//            ]);


            $check = \Bigbluebutton::server('server1')->all();
            $MeetingInfo = \Bigbluebutton::server('server1')->getMeetingInfo([
                'meetingID' => $id->teacher_id . '_' . $id->id,
            ]);


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
                $url = \Bigbluebutton::server('server1')->join([
                    'meetingID' => $mnt,
                    'userName' => $student->name . " " . $student->family,
                    'password' => $attendeePW
                ]);
            }
            return view($this->GetPreView() . 'Show', compact('teacherId','studentsId', 'MeetingInfo', 'url', 'id', 'check'));
        } else {
            return redirect(route('StudentsLoginView'));
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

}
