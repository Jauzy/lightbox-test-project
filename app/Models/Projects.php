<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = "projects";
    protected $primaryKey = 'prj_id';
    public $timestamps = false;

    protected $fillable = [
        'prj_name', 'prj_contact_person', 'prj_contact_person', 'prj_email', 'prj_phone', 'prj_address', 'prj_city',
        'prj_state', 'prj_country'
    ];
}
