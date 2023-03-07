<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectStages;
use App\Models\Products;
use App\Models\ProjectStageProductOffered;

class ProjectStageProducts extends Model
{
    protected $table = "project_stage_products";
    protected $primaryKey = 'psp_id';
    public $timestamps = false;

    public function project_stage(){
        return $this->belongsTo(ProjectStages::class, 'psp_ps_id', 'ps_id');
    }

    public function product(){
        return $this->belongsTo(Products::class, 'psp_pr_id', 'pr_id');
    }

    public function product_offered(){
        return $this->belongsTo(ProjectStageProductOffered::class, 'psp_pspo_id', 'pr_id');
    }
}
