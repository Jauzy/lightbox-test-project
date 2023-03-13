<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Models\Projects;
use App\Models\Products;
use App\Models\ProjectStages;
use App\Models\ProjectStageProducts;
use App\Models\ProjectStageProductOffered;

use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TenderComparison extends Controller
{
    public function printPDF($id){
        $data['id'] = $id;

        $data['filter_companies'] = $request->query('companies');
        $data['filter_date'] = $request->query('date');
        $data['filter_speces'] = $request->query('speces');

        $data['project'] = ProjectStages::with('stage_products', 'tenders')->where('ps_id', $id)->first();
        $data['stage_product'] = $data['project']->stage_products;
        $data['tenders'] = $data['project']->tenders;

        $data['project'] = ProjectStages::with(array(
        'stage_products' => function($q) use($data) {
            if($data['filter_speces'])
            $q->whereIn('psp_pr_id', explode(',',$data['filter_speces']));
        },
        'stage',
        'tenders' => function($q) use($data) {
            if($data['filter_companies'])
            $q->whereIn('pst_id', explode(',',$data['filter_companies']));
            if($data['filter_date']){
                $data['filter_date'] = date('d/m/Y', strtotime($data['filter_date']));
                $q->where('psto_date_input', '>=', $data['filter_date']);
            }
        },
        ))->where('ps_id', $id)->first();

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
            foreach($t->tender_product as $product){
                $companies_product[$product->pr_id][$t->pst_id] = $product;
            }
        }

        $data['companies_product'] = $companies_product;

        $pdf = Pdf::loadView('tender.comparison-pdf', $data)->setPaper('a3', 'landscape');
        return $pdf->stream('tender-comparison.pdf');
    }

    public function printPDFSimple($id, Request $request){
        $data['id'] = $id;

        $data['filter_companies'] = $request->query('companies');
        $data['filter_date'] = $request->query('date');
        $data['filter_speces'] = $request->query('speces');

        $data['project'] = ProjectStages::with('stage_products', 'tenders')->where('ps_id', $id)->first();
        $data['stage_product'] = $data['project']->stage_products;
        $data['tenders'] = $data['project']->tenders;

        $data['project'] = ProjectStages::with(array(
        'stage_products' => function($q) use($data) {
            if($data['filter_speces'])
            $q->whereIn('psp_pr_id', explode(',',$data['filter_speces']));
        },
        'stage',
        'tenders' => function($q) use($data) {
            if($data['filter_companies'])
            $q->whereIn('pst_id', explode(',',$data['filter_companies']));
            if($data['filter_date']){
                $data['filter_date'] = date('d/m/Y', strtotime($data['filter_date']));
                $q->where('psto_date_input', '>=', $data['filter_date']);
            }
        },
        ))->where('ps_id', $id)->first();

        $companies_product = [];
        foreach($data['project']->tenders as $t){
            foreach($t->tender_product as $product){
                $companies_product[$product->pr_id][$t->pst_id] = $product;
            }
        }

        $data['companies_product'] = $companies_product;

        $pdf = Pdf::loadView('tender.simple-comparison-pdf', $data)->setPaper('a3', 'landscape');
        return $pdf->stream('tender-comparison.pdf');
    }

    public function exportExcel($id, $ps_id){
        ini_set('memory_limit', '-1');
        $editFile = 'export-excell.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($editFile);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode('tender-comparison.xlsx').'"');
        ob_end_clean();
        ob_start();
        $writer->save('php://output');
    }
}
