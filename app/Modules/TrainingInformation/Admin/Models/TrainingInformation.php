<?php

namespace App\Modules\TrainingInformation\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingInformation extends Model
{
    protected $table = 'training_information';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title','teacher_id', 'school_id', 'grade_id', 'base_id', 'class_id',
        'date', 'file_type','file', 'created_at', 'updated_at'
    ];
}
