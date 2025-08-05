<?php

namespace App\Modules\Principal\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    protected $table = 'principal';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'family', 'phone', 'code', 'national_code', 'password',
        'school_id', 'email', 'created_at', 'updated_at'
    ];
}
