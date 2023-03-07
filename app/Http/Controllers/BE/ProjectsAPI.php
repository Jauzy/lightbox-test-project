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

class ProjectsAPI extends Controller
{

    public function list()
    {
        $data = Projects::with('company', 'stages')->get();
        return datatables($data)
        ->addColumn('name', function ($db) {
            $url = url('projects/'.$db->prj_id.'/form');
            return '
                <div>
                    <a href="'.$url.'" class="text-primary">'.$db->prj_name.'</a>
                    <div>'.$db->prj_last_upd.'</div>
                </div>
            ';
        })
        ->addColumn('company', function($db){
            return $db->company->ms_company_name;
        })
        ->addColumn('level', function ($db) {

            $html = '<div class="d-flex flex-column" style="gap:10px">';

            foreach($db->stages as $item){
                $url = url('/projects/'.$item->ps_prj_id.'/form/'.$item->ps_id);
                $html .= '
                    <a href="'.$url.'" class="btn btn-outline-primary btn-sm" style="max-width:300px">
                        '.$item->ps_level_name. '
                    </a>
                ';
            }

            $html .= '</div>';

            return $html;
        })
        ->rawColumns(['name', 'level'])->toJson();
    }

    public function getById($id)
    {
        return Projects::find($id)->toJson();
    }

    public function saveF(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = Projects::find($request->id) ?? new Projects();

            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }

            $dbs->prj_last_upd = date('d-m-Y');

            $dbs->save();

            $project_stage = new ProjectStages();
            $project_stage->ps_prj_id = $dbs->prj_id;
            $project_stage->ps_level_name = 'Default Level';
            $project_stage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data',
                'id' => $dbs->prj_id
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan data',
        ]);
    }


    public function delF($id)
    {
        try {
            $data = Projects::find($id);
            $main_photo = $data->pr_main_photo;
            $dimension_photo = $data->pr_dimension_photo;
            $photometric_photo = $data->pr_photometric_photo;
            $accessories_photo = $data->pr_accessories_photo;

            // delete files
            Storage::disk('local')->delete($main_photo);
            Storage::disk('local')->delete($dimension_photo);
            Storage::disk('local')->delete($photometric_photo);
            Storage::disk('local')->delete($accessories_photo);

            // delete data
            $data->delete();


            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus data',
        ]);
    }

    //-----------------------------------------------------------------------
    // Custom Function Place HERE !
    //-----------------------------------------------------------------------

    public function exportPDF($id, $ps_id){
        $project = ProjectStages::with('stage_products', 'stage')->where('ps_prj_id', $id)->where('ps_id', $ps_id)->first();

        $products = $project->stage_products;
        $data = $project->project;

        $pdf = Pdf::loadView('projects.export-pdf', compact('data', 'products', 'project'));
        return $pdf->stream('invoice.pdf');
    }

    public function exportExcel($id, $ps_id){
        ini_set('memory_limit', '-1');
        $editFile = 'export-excell.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($editFile);

        $project = ProjectStages::with('stage_products', 'stage')->where('ps_prj_id', $id)->where('ps_id', $ps_id)->first();

        foreach($project->stage_products as $product){
            $this->createSheet($product->psp_pspo_id, $spreadsheet, $project);
        }

        $spreadsheet->removeSheetByIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($project->project->prj_name.'.xlsx').'"');
        ob_end_clean();
        ob_start();
        $writer->save('php://output');
    }

    public function createSheet($id, $spreadsheet, $project){
        $db = ProjectStageProductOffered::with('category', 'lumtype', 'brand')->find($id);

        $sheet = clone $spreadsheet->getSheetByName('Sheet');
        $sheet->setTitle($db->pr_code);
        $spreadsheet->addSheet($sheet);

        $sheet->setCellValue('C3', $project->project->prj_name);
        $sheet->setCellValue('C10', $db->category->ms_cat_name);
        $sheet->setCellValue('H10', 'Code : '.$db->pr_code);
        $sheet->setCellValue('H13', $db->lumtype->ms_lum_types_name);
        $sheet->setCellValue('H15', $db->pr_light_source);
        $sheet->setCellValue('H17', $db->pr_lumen_output);
        $sheet->setCellValue('J15', $db->pr_lamp_type);
        $sheet->setCellValue('H19', $db->pr_optical);
        $sheet->setCellValue('H21', $db->pr_color_temperature);
        $sheet->setCellValue('H23', $db->pr_color_rendering);
        $sheet->setCellValue('H25', $db->pr_finishing);
        $sheet->setCellValue('A27', $db->pr_content);
        $sheet->setCellValue('H29', $db->pr_lumen_maintenance);
        $sheet->setCellValue('H31', $db->pr_ip_rating);
        $sheet->setCellValue('H33', $db->brand->ms_brand_name);
        $sheet->setCellValue('H35', $db->pr_model);
        $sheet->setCellValue('H38', $db->pr_driver);
        $sheet->setCellValue('H41', $db->pr_supplier);
        $sheet->setCellValue('H45', $db->pr_unit_price);

        $main = storage_path('app\\'.$db->pr_main_photo);
        $dimension = storage_path('app\\'.$db->pr_dimension_photo);
        $photometric = storage_path('app\\'.$db->pr_photometric_photo);

        $this->draw_image('main', $main, $sheet, 'A14');
        $this->draw_image('dimension', $dimension, $sheet, 'D16');
        $this->draw_image('photometric', $photometric, $sheet, 'C31');

    }

    private function draw_image($name, $path, $sheet, $coord){
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName($name);
        $drawing->setDescription($name);
        $drawing->setOffsetX(20);

        $drawing->setHeight(1);
        $drawing->setWidth(200);
        $drawing->setResizeProportional(false);


        $drawing->setPath($path); // put your path and image here
        $drawing->setCoordinates($coord);
        $drawing->setWorksheet($sheet);
    }

    public function saveStage(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = ProjectStages::find($request->id) ?? new ProjectStages();

            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }

            $dbs->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data',
                'id' => $dbs->ps_id
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan data',
        ]);
    }

    public function assignProduct(Request $request)
    {
        try {
            $ps_id = $request->ps_id;
            $pr_ids = explode(',', $request->pr_ids);

            foreach($pr_ids as $id){
                $product = Products::find($id)->toArray();
                $offered = new ProjectStageProductOffered();
                foreach($product as $key => $val){
                    if($key != 'pr_id')
                    $offered[$key] = $val;
                }
                $offered->save();

                $dbs = new ProjectStageProducts();
                $dbs->psp_ps_id = $ps_id;
                $dbs->psp_pr_id = $id;
                $dbs->psp_pspo_id = $offered->pr_id;
                $dbs->save();
            }

            $dbs->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data',
                'id' => $dbs->ps_id
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan data',
        ]);
    }

    public function saveFProdukOffered(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = ProjectStageProductOffered::find($request->id) ?? new ProjectStageProductOffered();

            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }
            $dbs->save();

            $type = [
                'pr_main_photo' => 'main',
                'pr_dimension_photo' => 'dimension',
                'pr_photometric_photo' => 'photometric',
                'pr_accessories_photo' => 'accessories',
            ];

            foreach($request->file() as $key => $file){
                // upload to storage
                $extension = $file->getClientOriginalExtension();
                $path = 'public\\Offered\\'.$dbs->pr_code.'-'.$dbs->pr_id.'.'.$type[$key].'.'.$extension;
                Storage::disk('local')->put($path, file_get_contents($file));
                $dbs[$key] = $path;
            }

            $dbs->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Success to save data',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to save data',
        ]);
    }


    public function delFProdukOffered($id)
    {
        try {

            $psp = ProjectStageProducts::where('psp_pspo_id', $id)->first();
            $data = ProjectStageProductOffered::find($id);
            $accessories_photo = $data->pr_accessories_photo;

            if($accessories_photo)
            Storage::disk('local')->delete($accessories_photo);

            // delete data
            $psp->delete();
            $data->delete();


            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus data',
        ]);
    }

}
