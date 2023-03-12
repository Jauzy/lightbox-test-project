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

class TenderComparison extends Controller
{
    public function index($id, Request $request){
        $data['id'] = $id;
        $data['company'] = MsCompany::all();
        $data['stages'] = MsStages::all();
        $data['brands'] = MsBrands::all();
        $data['categories'] = MsCategories::all();
        $data['lumtypes'] = MsLumTypes::all();
        $data['project'] = ProjectStages::with('stage_products', 'stage', 'tenders')->where('ps_id', $id)->first();

        $data['comparison_table'] = [
            'ms_lum_types_name' => 'Luminaire Type',
            'ms_brand_name' => 'Manufacturer',
            'pr_model' => 'Model',
            'pr_light_source' => 'Light Source',
            'pr_lumen_output' => 'Lumen Output',
            'pr_color_temperature' => 'Color Temprature',
            'pr_optical' => 'Beam Angle',
            'pr_color_rendering' => 'CRI',
            'pr_ip_rating' => 'IP rating',
            'pr_driver' => 'Driver Type',
            'pspo_notes' => 'Material Accessories',
            'pr_main_photo' => 'Photo',
            'pr_dimension_photo' => 'Dimension',
            'pr_photometric_photo' => 'Photometric',
            'psto_supplied_as' => 'Supplied as',
        ];

        $companies_product = [];
        foreach($data['project']->tenders as $t){
            $companies_product[$t->tender_product->pr_code][$t->pst_id] = $t->tender_product;
        }

        $data['companies_product'] = $companies_product;

        $data['filter_companies'] = $request->query('companies');
        $data['filter_date'] = $request->query('date');
        $data['filter_speces'] = $request->query('speces');


        return view('tender.comparison', $data);
    }

    public function simple($id, Request $request){
        $data['id'] = $id;
        $data['company'] = MsCompany::all();
        $data['stages'] = MsStages::all();
        $data['brands'] = MsBrands::all();
        $data['categories'] = MsCategories::all();
        $data['lumtypes'] = MsLumTypes::all();
        $data['project'] = ProjectStages::with('stage_products', 'stage', 'tenders')->where('ps_id', $id)->first();

        $data['filter_companies'] = $request->query('companies');
        $data['filter_date'] = $request->query('date');
        $data['filter_speces'] = $request->query('speces');


        return view('tender.simple-comparison', $data);
    }
}
