<?php

namespace App\Modules\Users\Admin\Models;

use App\Modules\Base\Admin\Models\Base;
use App\Modules\Grade\Admin\Models\Grade;
use App\Modules\SchoolList\Admin\Models\SchoolList;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use Illuminate\Database\Eloquent\Model;

//use App\Modules\Log\Admin\Models\Log;

class Users extends Model
{
    protected $fillable = [
        'group_name', 'group_logo', 'group_address', 'group_postalCode', 'group_phone',
        'phone', 'password', 'national_code', 'name', 'family', 'code',
        'birthday', 'email', 'address', 'user_category_id',
        'permissions', 'created_at', 'updated_at',
        'status', 'level', 'user_valid', 'type'
    ];
    protected $casts = [
        'permissions' => 'array',
    ];

    public function usercategory()
    {
        return $this->belongsTo(UserCategory::class, 'user_category_id');
    }

    public static function Get($id)
    {
        if (Users::where('id', $id)->exists()) {
            return Users::where('id', $id)->get()[0];
        }
    }


    public static function GetUserWithCategoryDetails($id)
    {
        return Users::where('users.id', $id)->join('user_categories', 'users.user_category_id', '=', 'user_categories.id')->get();
    }


    public static function CheckUsersExists($id)
    {
        if (Users::where('id', $id)->exists()) {
            return true;
        } else {
            return false;
        }
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
//    public function log()
//    {
//        return $this->belongsToMany(Log::class);
//    }
    public function schoolList()
    {
        return $this->belongsToMany(SchoolList::class);
    }

}
