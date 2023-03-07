<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class MsBrands extends Model
{
    protected $connection = 'master-schema';
    protected $table = "ms_brands";
    protected $primaryKey = 'ms_brand_id';
    public $timestamps = false;
}
