<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Masterdata\MsCategories;
use App\Models\Masterdata\MsLumTypes;
use App\Models\Masterdata\MsBrands;

class ProjectStageTenderOffered extends Model
{
    protected $table = "project_stage_tender_offered";
    protected $primaryKey = 'psto_id';
    public $timestamps = false;
}
