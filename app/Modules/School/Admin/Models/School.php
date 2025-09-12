<?php

namespace App\Modules\School\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'code', 'user_id', 'province', 'city', 'address',
        'postal_code', 'area_code', 'phone', 'this_domain',
        'subdomain', 'subdomain_name', 'another_domain', 'register_type',
        'another_domain_name', 'created_at', 'updated_at',
    ];
}
