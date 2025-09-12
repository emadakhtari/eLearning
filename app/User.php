<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

        $userPermissions = json_decode($this->permissions, true)['admin'];
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
