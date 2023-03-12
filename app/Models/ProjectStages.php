<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\MsStages;
use App\Models\Projects;
use App\Models\ProjectStageProducts;
use App\Models\ProjectStageTender;

class ProjectStages extends Model
{
    protected $table = "project_stages";
    protected $primaryKey = 'ps_id';
    public $timestamps = false;

    public function stage(){
        return $this->belongsTo(MsStages::class, 'ps_stage_id', 'stage_id');
    }

    public function project(){
        return $this->belongsTo(Projects::class, 'ps_prj_id', 'prj_id');
    }

    public function stage_products(){
        return $this->hasMany(ProjectStageProducts::class, 'psp_ps_id', 'ps_id');
    }

    public function tenders(){
        return $this->hasMany(ProjectStageTender::class, 'pst_ps_id', 'ps_id');
    }

}
