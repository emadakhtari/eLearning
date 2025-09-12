<?php

namespace App\Modules\GeneralInformation\Admin\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class GeneralInformation extends Model
{
    use Timestamp;

    public $timestamps = true;
    protected $table = 'general_information';
    protected $primaryKey = 'id';
    protected $fillable = [
        'teacher_id', 'school_id', 'grade_id', 'base_id', 'class_id',
        'lesson_id', 'file_type', 'file'
    ];
}
