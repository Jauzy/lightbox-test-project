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

        $pdf = Pdf::loadView('tender.comparison-pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('tender-comparison.pdf');
    }

    public function printPDFSimple($id, Request $request){
        $data['project'] = ProjectStages::with('stage_products', 'stage', 'tenders')->where('ps_id', $id)->first();

        $data['filter_companies'] = $request->query('companies');
        $data['filter_date'] = $request->query('date');
        $data['filter_speces'] = $request->query('speces');

        $pdf = Pdf::loadView('tender.simple-comparison-pdf', $data)->setPaper('a4', 'landscape');
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
