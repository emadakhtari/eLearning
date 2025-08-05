<?php

namespace App\Modules\Supervisor\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisor';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'family', 'phone', 'code', 'national_code', 'password',
        'school_id', 'email', 'created_at', 'updated_at'
    ];
}
