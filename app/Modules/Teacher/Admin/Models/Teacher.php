<?php

namespace App\Modules\Teacher\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $table = 'teacher';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'family',
        'phone',
        'code',
        'national_code',
        'password',
        'school_id',
        'email',
        'created_at',
        'updated_at'
    ];
}