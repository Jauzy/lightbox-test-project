<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class MsUsers extends Model
{
    protected $connection = 'master-schema';
    protected $table = "ms_users";
    protected $primaryKey = 'user_id';
    public $timestamps = false;
}
