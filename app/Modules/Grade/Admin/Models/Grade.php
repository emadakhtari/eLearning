<?php

namespace App\Modules\Grade\Admin\Models;

use App\Modules\Users\Admin\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title','user_id','forced', 'created_at', 'updated_at'

    ];
}
