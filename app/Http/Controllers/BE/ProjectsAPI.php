<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Models\Projects;
use App\Models\ProjectProducts;
use App\Models\Products;
use App\Models\ProductSubmited;

use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProjectsAPI extends Controller
{

    public function list()
    {
        $data = Projects::all();
        return datatables($data)
        ->addColumn('action', function ($db) {
            $action = '
                <a class="dropdown-item d-flex align-items-center text-secondary" style="gap:5px" href="'.url('projects/'.$db->prj_id.'/form').'">
                    <i style="font-size:18px"  class="bx bx-edit " ></i>
                    <span>Edit</span>
            </a>
            ';
            return '
                <div class="btn-group dropend" style="">
                    <button type="button" class="btn btn-action rounded-pill btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                        '.$action.'
                    </div>
                </div>
            ';
        })
        ->addColumn('name', function ($db) {
            $url = url('projects/'.$db->prj_id.'/form');
            return '
                <div>
                    <a href="'.$url.'" class="text-primary">'.$db->prj_name.'</a>
                    <div>'.$db->prj_last_upd.'</div>
                </div>
            ';
        })
        ->addColumn('location', function ($db) {
            return '
                <div>
                    <div>'.$db->prj_city.', ' . $db->prj_state . ', ' . $db->prj_country . '</div>
                    <div>'.$db->prj_address.'</div>
                </div>
            ';
        })
        ->addColumn('level', function ($db) {
            $products = ProjectProducts::leftJoin('products', 'products.pr_id', '=', 'project_products.pr_id')
                ->where('prj_id', $db->prj_id)->get();

            $html = '<div class="d-flex flex-column" style="gap:10px">';

            foreach($products as $product){
                $url = url('getimage/'.base64_encode($product->pr_main_photo));
                $html .= '
                    <div class="d-flex align-items-center p-1 rounded btn btn-outline-primary btn-sm">
                        '.$product->pr_prj_location.' - ' . $product->pr_code . '
                    </div>
                ';
            }

            $html .= '</div>';

            return $html;
        })
        ->rawColumns(['action','name', 'location', 'level'])->toJson();
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

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data',
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

    public function exportPDF($id){
        $data = Projects::find($id);
        $products = ProjectProducts::leftJoin('products', 'products.pr_id', '=', 'project_products.pr_id')
            ->where('prj_id', $id)->get();

        $temp_product = [];
        foreach($products as $product){
            $product_submit = ProductSubmited::where('pr_id', $product->pr_id)->where('stp_prj_id', $data->prj_id)->first();
            if($product_submit){
                $temp_product[] = $product_submit;
            } else
            $temp_product[] = $product;
        }

        $products = $temp_product;

        $pdf = Pdf::loadView('projects.export-pdf', compact('data', 'products'));
        return $pdf->stream('invoice.pdf');
    }

    public function assignProduct(Request $request){
        $prj_id = $request->prj_id;
        $product_id = $request->product_id;

        $data = new ProjectProducts();
        $data->prj_id = $prj_id;
        $data->pr_id = $product_id;
        $data->pr_prj_location = $request->pr_prj_location;
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Success to save data',
        ]);
    }

    public function delProductAssigned($id){
        $data = ProjectProducts::find($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Success to save data',
        ]);
    }

    public function exportExcel($id){
        ini_set('memory_limit', '-1');
        $editFile = 'export-excell.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($editFile);

        $project = Projects::find($id);
        $products = ProjectProducts::leftJoin('products', 'products.pr_id', '=', 'project_products.pr_id')
            ->where('prj_id', $id)->get();

        foreach($products as $product){
            $this->createSheet($product->pr_id, $spreadsheet, $project);
        }

        $spreadsheet->removeSheetByIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($project->prj_name.'-'.$project->prj_country.'.xlsx').'"');
        ob_end_clean();
        ob_start();
        $writer->save('php://output');
    }

    public function createSheet($id, $spreadsheet, $project){
        $db = Products::find($id);

        $sheet = clone $spreadsheet->getSheetByName('Sheet');
        $sheet->setTitle($db->pr_code);
        $spreadsheet->addSheet($sheet);

        $keys = [
            'pr_application' => 'C10',
            'pr_code' => 'H10',
            'pr_luminaire_type' => 'H13',
            'pr_light_source' => 'H15',
            'pr_lumen_output' => 'H17',
            'pr_lamp_type' => 'J15',
            'pr_optical' => 'H19',
            'pr_color_temperature' => 'H21',
            'pr_color_rendering' => 'H23',
            'pr_finishing' => 'H25',
            'pr_content' => 'A27',
            'pr_lumen_maintenance' => 'H29',
            'pr_ip_rating' => 'H31',
            'pr_manufacturer' => 'H33',
            'pr_model' => 'H35',
            'pr_driver' => 'H38',
            'pr_supplier' => 'H41',
            'pr_unit_price' => 'H45',
        ];

        $sheet->setCellValue('C3', $project->prj_name);
        $sheet->setCellValue('C10', $db->pr_application);
        $sheet->setCellValue('H10', 'Code : '.$db->pr_code);
        $sheet->setCellValue('H13', $db->pr_luminaire_type);
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
        $sheet->setCellValue('H33', $db->pr_manufacturer);
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

    public function getProductSubmited($id, $prj_id)
    {
        $product = ProductSubmited::where('pr_id', $id)->where('stp_prj_id', $prj_id)->first();
        if(!$product){
            $product = Products::find($id);
        }
        return $product->toJson();
    }

    public function saveProductSubmited(Request $request, $prj_id)
    {
        try {
            $inp = $request->inp;
            $product = Products::find($inp['pr_id']);
            // search
            $dbs = ProductSubmited::where('pr_id', $inp['pr_id'])->where('stp_prj_id', $prj_id)->first();
            if(!$dbs) {
                $dbs = new ProductSubmited();
                $dbs->stp_prj_id = $prj_id;
            }
            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }

            $dbs->pr_main_photo = $product->pr_main_photo;
            $dbs->pr_dimension_photo = $product->pr_dimension_photo;
            $dbs->pr_photometric_photo = $product->pr_photometric_photo;
            $dbs->pr_accessories_photo = $product->pr_accessories_photo;

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
                $path = 'Submited\\'.$dbs->pr_code.'-'.$dbs->pr_id.'.'.$type[$key].'.'.$extension;
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

}
