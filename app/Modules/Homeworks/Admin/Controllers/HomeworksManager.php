<?php

namespace App\Modules\Homeworks\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\AssignGradeBase\Admin\Models\AssignGradeBase;
use App\Modules\Base\Admin\Models\Base;
use App\Modules\ClassAssign\Admin\Models\ClassAssign;
use App\Modules\Homeworks\Admin\Models\Homeworks;
use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\School\Admin\Models\School;
use App\Modules\Students\Admin\Models\Students;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\TeacherAssign\Admin\Models\TeacherAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeworksManager extends Controller
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

    //Return List Views
    public function ListView()
    {
        if (Auth::guard('teacher')->check() == true) {
            $teacherId = Auth::guard('teacher')->id();
            $teacherAdmin = Teacher::where('id', $teacherId)
                ->first();
            $SchoolSelect = School::where('id', $teacherAdmin->school_id)
                ->first();

            $assignGrade = AssignGradeBase::where('school_id', $teacherAdmin->school_id)
                ->first();

            $assignSelect = TeacherAssign::where('teacher_id', $teacherId)
                ->get();

            foreach ($assignSelect as $item) {
                $baseSelect[$item->id] = Base::where('id', $item->base_id)
                    ->first();
            }


            return view($this->GetPreView() . 'List', compact('teacherId', 'teacherAdmin', 'SchoolSelect', 'assignSelect', 'baseSelect', 'assignGrade'));
        } else {
            return redirect(route('TeacherLoginView'));
        }

    }

    public function ListViewAjax(Request $request)
    {
        $limit = 25000;

        $searchRequest = $request->input('search');
        $pageNumberRequest = $request->input('pageNumber');
        $base_idRequest = $request->input('base_id');
        $lesson_idRequest = $request->input('lesson_id');
        $class_idRequest = $request->input('class_id');
        $dateRequest = $request->input('date');
        $statusRequest = $request->input('status');

        $count = Homeworks::Count($searchRequest, $base_idRequest, $lesson_idRequest, $class_idRequest, $dateRequest, $statusRequest);


        if (is_int($count / $limit)) {
            $pagesCount = ($count / $limit);
        } else {
            $pagesCount = ((int)($count / $limit)) + 1;
        }


        if (empty($lesson_idRequest)) {
            $app = null;
        } else {
            if (!empty($pageNumberRequest)) {
                $offset = ($pageNumberRequest - 1) * $limit;
                $app = Homeworks::Search($searchRequest, $base_idRequest, $lesson_idRequest, $class_idRequest, $dateRequest, $statusRequest, $offset, $limit);
            } else {
                $app = Homeworks::Search($searchRequest, $base_idRequest, $lesson_idRequest, $class_idRequest, $dateRequest, $statusRequest, 0, $limit);
            }
        }


        return view($this->GetPreView() . 'Ajax_List', compact('count', 'limit'))->with('data', ['app' => $app, 'pageInfo' => ['curPage' => $pageNumberRequest, 'pagesCount' => $pagesCount]]);
    }

    public function classList(Request $request)
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

    public function lessonList(Request $request)
    {
        $teacherId = Auth::guard('teacher')->id();
        $class_id = $request->class_id;
        $base_id = $request->base_id;
        $school_id = $request->school_id;

        $ClassList = TeacherAssign::where('school_id', $school_id)
            ->where('teacher_id', $teacherId)
            ->where('base_id', $base_id)
            ->where('class_id', $class_id)
            ->get();

        if ($base_id) {
            $output = '<option value="0">انتخاب نشده</option>';

            foreach ($ClassList as $item) {
                $lesson = Lesson::where('id', $item->lesson_id)
                    ->first();
                $output .= '<option value="' . $item->lesson_id . '">' . $lesson->title . '</option>';
            }
        } else {
            $output = '<option value="">انتخاب نشده</option>';
        }
        return $output;
    }

    public function EditView($id)
    {
        if (Auth::guard('teacher')->check() == true) {
            $id = Homeworks::findOrFail($id);
            $teacherId = Auth::guard('teacher')->id();
            $teacherAdmin = Teacher::where('id', $teacherId)
                ->first();
            $SchoolSelect = School::where('id', $teacherAdmin->school_id)
                ->first();

            $assignGrade = AssignGradeBase::where('school_id', $teacherAdmin->school_id)
                ->first();

            $assignSelect = TeacherAssign::where('teacher_id', $teacherId)
                ->get();

            $baseSelect = Base::where('id', $id->base_id)
                ->first();
            $classSelect = ClassAssign::where('id', $id->class_id)
                ->first();
            $lessonSelect = Lesson::where('id', $id->lesson_id)
                ->first();
            $studentSelect = Students::where('id', $id->student_id)
                ->first();

            return view($this->GetPreView() . 'Edit', compact('teacherId', 'teacherAdmin', 'SchoolSelect', 'assignGrade', 'assignSelect', 'baseSelect', 'classSelect', 'lessonSelect', 'studentSelect'))->with(['data' => $id]);
        } else {
            return redirect(route('TeacherLoginView'));
        }
    }

    public function Edit(Request $request, $id)
    {

        $rules = array(
            'status' => [
                'required',
            ],
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $Homeworks = Homeworks::findOrFail($id);

            $Homeworks->update(
                [
                    'status' => $request->status,
                    'details' => $request->details
                ]
            );
            return redirect(route('Homeworks.List.View'))->with('success',
                'با موفقیت انجام شد.'
            )->withInput();
        } else {
            return back()->withErrors('لطفا وضعیت تکلیف را مشخص نمائید.');
        }
    }
}
