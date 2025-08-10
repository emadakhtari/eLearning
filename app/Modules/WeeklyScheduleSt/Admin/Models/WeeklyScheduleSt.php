<?php

namespace App\Modules\WeeklyScheduleSt\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyScheduleSt extends Model
{
    protected $table = 'schedule';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'school_id', 'deputy_id', 'grade_id', 'base_id', 'class_id', 'lesson_id', 'teacher_id',
        'week_day', 'time_number', 'start_time', 'end_time', 'created_at', 'updated_at'
    ];
}
