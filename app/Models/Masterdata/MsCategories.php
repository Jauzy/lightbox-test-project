<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class MsCategories extends Model
{
    protected $connection = 'master-schema';
    protected $table = "ms_categories";
    protected $primaryKey = 'ms_cat_id';
    public $timestamps = false;
}
