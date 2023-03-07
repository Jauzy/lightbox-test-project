<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Masterdata\MsCategories;
use App\Models\Masterdata\MsLumTypes;
use App\Models\Masterdata\MsBrands;

class Products extends Model
{
    protected $table = "products";
    protected $primaryKey = 'pr_id';
    public $timestamps = false;

    protected $fillable = [
        'pr_application', 'pr_optical', 'pr_lamp_type', 'pr_lumen_output', 'pr_light_source', 'pr_luminaire_type', 'pr_code',
        'pr_manufacturer', 'pr_ip_rating', 'pr_lumen_maintenance', 'pr_content', 'pr_finishing', 'pr_color_rendering', 'pr_color_temperature',
        'pr_model', 'pr_driver', 'pr_supplier', 'pr_unit_price', 'pr_main_photo', 'pr_photometric_photo', 'pr_dimension_photo',
        'pr_accessories_photo'
    ];

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
