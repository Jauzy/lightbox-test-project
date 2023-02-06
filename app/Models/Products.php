<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
