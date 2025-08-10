<?php

namespace App\Modules\Students\Admin\Models;

use App\Modules\Homeworks\Admin\Models\Homeworks;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Students extends Authenticatable
{
    use Notifiable;

    protected $table = 'student';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'family','image', 'phone', 'code', 'national_code', 'password', 'school_id',
        'deputy_id', 'grade_id', 'base_id', 'class_id', 'email', 'created_at', 'updated_at'
    ];

    public function homeworks()
    {
        return $this->hasMany(Homeworks::class);
    }
}
