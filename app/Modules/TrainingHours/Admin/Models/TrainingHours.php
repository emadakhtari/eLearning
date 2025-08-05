<?php

namespace App\Modules\TrainingHours\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingHours extends Model
{
    protected $table = 'training_hours';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'school_id', 'deputy_id', 'week_day', 'time_number',
        'start_time', 'end_time', 'created_at', 'updated_at'
    ];
}
