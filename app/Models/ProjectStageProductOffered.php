<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Masterdata\MsCategories;
use App\Models\Masterdata\MsLumTypes;
use App\Models\Masterdata\MsBrands;

class ProjectStageProductOffered extends Model
{
    protected $table = "project_stage_product_offered";
    protected $primaryKey = 'pr_id';
    public $timestamps = false;

    public function category(){
        return $this->belongsTo(MsCategories::class, 'pr_application', 'ms_cat_id');
    }

    public function lumtype(){
        return $this->belongsTo(MsLumTypes::class, 'pr_luminaire_type', 'ms_lum_types_id');
    }

    public function brand(){
        return $this->belongsTo(MsBrands::class, 'pr_manufacturer', 'ms_brand_id');
    }
}
