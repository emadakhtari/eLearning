<?php

namespace App\Modules\Homeworks\Admin\Models;

use App\Modules\Lesson\Admin\Models\Lesson;
use App\Modules\Students\Admin\Models\Students;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Homeworks extends Model
{
    use Timestamp;

    protected $table = 'homeworks';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'student_id', 'school_id', 'grade_id', 'base_id',
        'class_id', 'lesson_id', 'date', 'file_type', 'status', 'details', 'file'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public static function Count($title, $base_id, $lesson_id, $class_id, $date, $status)
    {
        $search = Students::where('family', 'like', '%' . $title . '%')->pluck('id')->toArray();
        if ($base_id && $class_id && $lesson_id) {
            if ($status) {
                if ($status == 'unseen') {
                    $status = '0';
                }
                if ($date) {
                    $date = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $date)->toCarbon()->format('Y-m-d');
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('class_id', $class_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('date', $date)
                        ->where('status', $status)
                        ->count();
                } else {
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('class_id', $class_id)
                        ->where('status', $status)
                        ->count();
                }
            } else {
                if ($date) {
                    $date = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $date)->toCarbon()->format('Y-m-d');
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('class_id', $class_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('date', $date)
                        ->count();
                } else {
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('class_id', $class_id)
                        ->count();
                }
            }

        }
    }

    public static function Search($title, $base_id, $lesson_id, $class_id, $date, $status, $offset, $limit)
    {
        $search = Students::where('family', 'like', '%' . $title . '%')->pluck('id')->toArray();
        if ($base_id && $class_id && $lesson_id) {
            if ($status) {
                if ($status == 'unseen') {
                    $status = '0';
                }
                if ($date) {
                    $date = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $date)->toCarbon()->format('Y-m-d');
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('class_id', $class_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('date', $date)
                        ->where('status', $status)
                        ->offset($offset)->take($limit)->orderBy('id', 'desc')->get();
                } else {
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('class_id', $class_id)
                        ->where('status', $status)
                        ->offset($offset)->take($limit)->orderBy('id', 'desc')->get();
                }
            } else {
                if ($date) {
                    $date = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $date)->toCarbon()->format('Y-m-d');
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('class_id', $class_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('date', $date)
                        ->offset($offset)->take($limit)->orderBy('id', 'desc')->get();
                } else {
                    return Homeworks::whereIn('homeworks.student_id', $search)
                        ->where('base_id', $base_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('class_id', $class_id)
                        ->offset($offset)->take($limit)->orderBy('id', 'desc')->get();
                }
            }
        }

    }

}
