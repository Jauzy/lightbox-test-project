<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class MsCompany extends Model
{
    protected $connection = 'master-schema';
    protected $table = "ms_company";
    protected $primaryKey = 'ms_company_id';
    public $timestamps = false;
}
