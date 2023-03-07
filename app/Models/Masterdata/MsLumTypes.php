<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class MsLumTypes extends Model
{
    protected $connection = 'master-schema';
    protected $table = "ms_lum_types";
    protected $primaryKey = 'ms_lum_types_id';
    public $timestamps = false;
}
