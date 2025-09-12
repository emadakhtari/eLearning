<?php

namespace App\Modules\ClassesCompleted\Admin\Models;

use App\Modules\Users\Admin\Models\Users;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class ClassesCompleted extends Model
{
    use Timestamp;

    protected $table = 'classes_completed';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'schedule_id', 'holding_date', 'holding_time'
    ];
}
