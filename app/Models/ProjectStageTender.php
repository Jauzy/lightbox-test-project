<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProjectStageTenderOffered;

class ProjectStageTender extends Model
{
    protected $table = "project_stage_tender";
    protected $primaryKey = 'pst_id';
    public $timestamps = false;

    public function tender_product(){
        return $this->hasOne(ProjectStageTenderOffered::class, 'psto_pst_id', 'pst_id');
    }
}
