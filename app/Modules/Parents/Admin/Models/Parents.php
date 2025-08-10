<?php

namespace App\Modules\Parents\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parents';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'family', 'phone', 'code', 'national_code', 'password', 'student_id', 'school_id',
        'deputy_id', 'grade_id', 'base_id', 'class_id', 'email', 'created_at', 'updated_at'
    ];
}
