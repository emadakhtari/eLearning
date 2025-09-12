<?php

namespace App\Modules\HomeworkUpload\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class HomeworkUpload extends Model
{
    protected $table = 'homeworks';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title','student_id', 'school_id', 'grade_id', 'base_id', 'class_id', 'lesson_id',
        'date', 'file_type','file', 'created_at', 'updated_at'
    ];
}
