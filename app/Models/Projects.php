<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\MsCompany;

use App\Models\ProjectStages;

class Projects extends Model
{
    protected $table = "projects";
    protected $primaryKey = 'prj_id';
    public $timestamps = false;

    protected $fillable = [
        'prj_name', 'prj_contact_person', 'prj_contact_person', 'prj_email', 'prj_phone', 'prj_address', 'prj_city',
        'prj_state', 'prj_country'
    ];

    public function company(){
        return $this->belongsTo(MsCompany::class, 'prj_company_id', 'ms_company_id');
    }

    public function stages(){
        return $this->hasMany(ProjectStages::class, 'ps_prj_id', 'prj_id');
    }
}
