<?php

namespace App\Modules\Base\Admin\Models;

use App\Modules\Users\Admin\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $table = 'base';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title','grade_id','user_id', 'created_at', 'updated_at'
    ];

}
