<?php

namespace App\Modules\Setting\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table      = 'setting';
    public $timestamps    = true;
    protected $primaryKey = 'id';
    protected $fillable   = [
        'title', 'login_image', 'top_menu_image','signature_image',
        'software_text', 'owner_text', 'powered_text', 'license_text',
        'created_at', 'updated_at'
    ];
}
