<?php

namespace App\Modules\StudentsAbsentPresent\Admin\Models;

use App\Modules\Users\Admin\Models\Users;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class StudentsAbsentPresent extends Model
{
    use Timestamp;

    protected $table = 'students_absent_present';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'classes_completed_id', 'student_id',
        'delay', 'haste', 'status'
    ];
}
