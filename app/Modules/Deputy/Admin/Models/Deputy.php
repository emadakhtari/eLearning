<?php

namespace App\Modules\Deputy\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Deputy extends Authenticatable
{
    use Notifiable;

    public $timestamps = true;
    protected $table = 'deputy';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'family', 'phone', 'code', 'national_code', 'password', 'above_id',
        'school_id', 'email', 'level', 'permissions', 'status', 'created_at', 'updated_at'
    ];
    public function hasPermission($permission)
    {
        $jsonArray = json_decode($this->permissions, true);


//        if ($this->id == 1)
//        {
//            return true;
//        }
        // separate permission
        $step = explode('.', $permission);

        if ($this->permissions) {
            $userPermissions = json_decode($this->permissions, true)['admin'];
        } else {
            $userPermissions = null;
        }
        if (!empty($userPermissions[$step[0]]))
        {
            if (array_search($step[1], $userPermissions[$step[0]]['permissions']))
            {
                return true;
            }

            foreach ($userPermissions[$step[0]]['permissions'] as $key => $item)
            {
                $temp = json_decode($item, true);
                if (!empty($temp[$step[1]]))
                {
                    return true;
                }
            }
        }

        return false;
    }
}
