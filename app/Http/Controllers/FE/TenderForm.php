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

class TenderForm extends Controller
{
    public function index($id)
    {
        $data['company'] = MsCompany::all();
        $data['stages'] = MsStages::all();
        $data['brands'] = MsBrands::all();
        $data['categories'] = MsCategories::all();
        $data['lumtypes'] = MsLumTypes::all();
        $data['project'] = ProjectStages::with('stage_products', 'stage')->where('ps_id', $id)->first();

        $data['id'] = $id;

        return view('tender.submission-form', $data);
    }

    public function success(){
        return view('tender.success-submit-form');
    }
}
