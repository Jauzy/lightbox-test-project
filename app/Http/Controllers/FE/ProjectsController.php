<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Masterdata\MsCompany;
use App\Models\Masterdata\MsStages;
use App\Models\Masterdata\MsBrands;
use App\Models\Masterdata\MsCategories;
use App\Models\Masterdata\MsLumTypes;
use App\Models\ProjectStages;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('projects.list');
    }

    public function form($id, $stage = null){
        $data['id'] = $id;
        $data['company'] = MsCompany::all();
        $data['stages'] = MsStages::all();
        $data['brands'] = MsBrands::all();
        $data['categories'] = MsCategories::all();
        $data['lumtypes'] = MsLumTypes::all();


        if($stage){
            $data['selected_stage'] = ProjectStages::with('stage_products', 'stage')->where('ps_prj_id', $id)->where('ps_id', $stage)->first();
        } else {
            $data['selected_stage'] = ProjectStages::with('stage_products', 'stage')->where('ps_prj_id', $id)->first();
        }

        $data['project_stages'] = ProjectStages::with('stage_products', 'stage')->where('ps_prj_id', $id)->get();


        return view('projects.form', $data);
    }

    public function new(){
        $data['id'] = null;
        $data['company'] = MsCompany::all();
        $data['stages'] = MsStages::all();
        $data['brands'] = MsBrands::all();
        $data['categories'] = MsCategories::all();
        $data['lumtypes'] = MsLumTypes::all();

        $data['selected_stage'] = null;

        $data['project_stages'] = null;
        return view('projects.form', $data);
    }
}
