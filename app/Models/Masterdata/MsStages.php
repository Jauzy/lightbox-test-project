<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class MsStages extends Model
{
    protected $connection = 'master-schema';
    protected $table = "ms_stages";
    protected $primaryKey = 'stage_id';
    public $timestamps = false;
}
