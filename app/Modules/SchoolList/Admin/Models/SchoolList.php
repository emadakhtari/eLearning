<?php

namespace App\Modules\SchoolList\Admin\Models;

use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SchoolList extends Model
{
    protected $table = 'school';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'code', 'user_id', 'province', 'city', 'address',
        'postal_code', 'area_code', 'phone', 'this_domain',
        'subdomain', 'subdomain_name', 'another_domain',
        'another_domain_name', 'created_at', 'updated_at',

    ];

    public static function Search($title,$province,$city)
    {
        $userId = Auth::user()->id;
        $userSelect = Users::where('id' , $userId)
            ->first();
        $userCategorySelect = UserCategory::where('id' , $userSelect->user_category_id)
            ->first();
        if ($userCategorySelect->id == '1') {
            if ($province) {
                if ($city) {
                    return SchoolList::where('school.title', 'like', '%' . $title . '%')
                        ->where('province', $province)
                        ->where('city', $city)
                        ->get();
                } else {
                    return SchoolList::where('school.title', 'like', '%' . $title . '%')
                        ->where('province', $province)
                        ->get();
                }

            } else {
                return SchoolList::where('school.title', 'like', '%' . $title . '%')
                    ->get();
            }
        } else {
            if ($province) {
                if ($city) {
                    return SchoolList::where('school.title', 'like', '%' . $title . '%')
                        ->where('province', $province)
                        ->where('city', $city)
                        ->where('user_id', $userId)
                        ->orWhere('user_id', '1')
                        ->where('school.title', 'like', '%' . $title . '%')
                        ->where('province', $province)
                        ->where('city', $city)
                        ->get();
                } else {
                    return SchoolList::where('school.title', 'like', '%' . $title . '%')
                        ->where('province', $province)
                        ->where('user_id', $userId)
                        ->orWhere('user_id', '1')
                        ->where('school.title', 'like', '%' . $title . '%')
                        ->where('province', $province)
                        ->where('user_id', $userId)
                        ->get();
                }

            } else {
                return SchoolList::where('school.title', 'like', '%' . $title . '%')
                    ->where('user_id', $userId)
                    ->orWhere('user_id', '1')
                    ->where('school.title', 'like', '%' . $title . '%')
                    ->get();
            }
        }


    }


    public function userSelect()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
