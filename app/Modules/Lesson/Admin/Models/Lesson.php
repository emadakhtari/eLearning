<?php

namespace App\Modules\Lesson\Admin\Models;

use App\Modules\Homeworks\Admin\Models\Homeworks;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lesson';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title','grade_id','base_id','user_id', 'created_at', 'updated_at'
    ];
    public function homeworks()
    {
        return $this->hasMany(Homeworks::class);
    }
}
