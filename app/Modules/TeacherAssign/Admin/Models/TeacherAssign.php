<?php

namespace App\Modules\TeacherAssign\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAssign extends Model
{
    protected $table = 'teacher_assign';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'deputy_id', 'school_id', 'teacher_id', 'base_id',
        'lesson_id', 'class_id', 'created_at', 'updated_at'
    ];
}
