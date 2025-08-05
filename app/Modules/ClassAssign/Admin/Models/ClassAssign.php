<?php

namespace App\Modules\ClassAssign\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAssign extends Model
{
    protected $table = 'class_assign';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'grade_id', 'base_id', 'school_id', 'created_at', 'updated_at'
    ];
}
