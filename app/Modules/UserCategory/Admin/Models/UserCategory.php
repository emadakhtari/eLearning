<?php

namespace App\Modules\UserCategory\Admin\Models;

use App\Http\Controllers\CoreCommon;

use App\Modules\Users\Admin\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCategory extends Model
{
    protected $table = 'user_categories';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'permissions', 'status', 'created_at', 'updated_at'
    ];
    public function users()
    {
        return $this->belongsToMany(Users::class);
    }
    public static function GetWithId($id)
    {
        if (UserCategory::where('id', $id)->exists()) {
            return UserCategory::where('id', $id)->get()[0];
        } else {
            return false;
        }
    }

    public static function GetAll()
    {
        return UserCategory::all()->where('status', 1);
    }

    public static function Add($title, $permissions, $status)
    {
        if (!empty($title) && !empty($permissions)) {
            $category = new UserCategory();
            $category->title = $title;
            $category->permissions = json_encode($permissions);
            $category->status = $status;
            $category->save();
        }
    }


    public static function CheckUserCategoryExists($id)
    {
        if (UserCategory::where('id', $id)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public static function Edit($id, $title, $permissions, $status)
    {

        if (!empty($title) && !empty($permissions)) {
            if (UserCategory::where('id', $id)->exists()) {
                $category = UserCategory::where('id', $id)->get()[0];
                $category->title = $title;
                $category->permissions = json_encode($permissions);
                $category->status = $status;
                $category->save();
            }
        }
    }



//    public function users()
//    {
//        return $this->hasMany(Users::class);
//    }


    public function getUserCanViewAttribute()
    {
        if (CoreCommon::UserHaveAllPermission($this->GetModuleName())) {
            $userPermissions = json_decode(Auth::guard('web')->user()->permissions, true)['admin'];
            $permInfo = $this->extractPermissions($userPermissions);
            foreach ($permInfo as $category => $actions) {
                foreach ($actions as $action => $status) {
                    if (isset($permissionses[$category][$action])) {
                        $permInfo[$category][$action] = true;
                    }
                }
            }

        }
    }

    public function GetModuleName()
    {
        $dd = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest = json_decode($manifestJson, true);
        $moduleName = $manifest['title'];
        return $moduleName;
    }

    private function extractPermissions($permissions)
    {
        $data = [];

        foreach ($permissions as $categoryName => $categoryValues) {

            foreach ($categoryValues['permissions'] as $permissionGroup) {
                $temp = json_decode($permissionGroup, true);

                if (!empty($temp)) {
                    foreach ($temp as $actionName => $item) {
                        $data[$categoryName][$actionName] = false;
                    }
                } else {
                    $data[$categoryName][$permissionGroup] = false;
                }
            }
        }
        return $data;
    }


}
