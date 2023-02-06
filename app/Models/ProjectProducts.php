<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectProducts extends Model
{
    protected $table = "project_products";
    protected $primaryKey = 'pr_prj_id';
    public $timestamps = false;
}
