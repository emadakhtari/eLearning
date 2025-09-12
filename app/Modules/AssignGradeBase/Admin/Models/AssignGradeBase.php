<?php

namespace App\Modules\AssignGradeBase\Admin\Models;

use App\Modules\Users\Admin\Models\Users;
use Illuminate\Database\Eloquent\Model;

class AssignGradeBase extends Model
{
    protected $table = 'assign_grade_base';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id','grade_id','base_id', 'school_id', 'created_at', 'updated_at'

    ];
}
