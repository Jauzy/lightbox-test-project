<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Models\Products;
use App\Models\Masterdata\MsCategories;
use App\Models\Masterdata\MsLumTypes;
use App\Models\Masterdata\MsBrands;

use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProductsAPI extends Controller
{

    public function list(Request $request)
    {
        $prj_id = $request->prj_id;

        if($prj_id){
            $data = Products::with('brand','category','lumtype')
                ->leftJoin('project_products', 'project_products.pr_id', '=', 'products.pr_id')
                ->where('project_products.prj_id', $prj_id)
                ->get();
        } else {
            $data = Products::with('brand','category','lumtype')->get();
        }

        return datatables($data)
            ->addColumn('checkbox', function ($db) {
                return '
                    <input type="checkbox" class="form-check-input" name="selected_products[]" value="'.$db->pr_id.'">
                ';
            })
            ->addColumn('action', function ($db) {
                $action = '
                    <a class="dropdown-item d-flex align-items-center text-secondary" style="gap:5px" href="javascript:detail(\''.$db->pr_id.'\')">
                        <i style="font-size:18px"  class="bx bx-show " ></i>
                        <span>Details</span>
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
            ->addColumn('action_del', function ($db) {
                $action = '
                    <a class="dropdown-item d-flex align-items-center text-danger" style="gap:5px" href="javascript:delProduct(\''.$db->pr_prj_id.'\')">
                        <i style="font-size:18px"  class="bx bx-show " ></i>
                        <span>Delete</span>
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
            ->addColumn('lumen', function ($db) {
                $url = url('getimage/'.base64_encode($db->pr_main_photo));

                return '
                    <div class="d-flex align-items-center" style="gap:10px">
                        <img src="'.$url.'" alt="image" class="rounded" style="height:80px;width:80px;object-fit:contain">
                        <div>
                            <a href="'.url('masterdata/products/'.$db->pr_id.'/form').'" class="text-primary fw-bolder"><strong>'.$db->pr_code.'</strong></a>
                            <div>'.$db->lumtype->ms_lum_types_name.'</div>
                            <div>'.$db->pr_lamp_type.' | '.$db->pr_light_source.' | '.$db->pr_lumen_output.'</div>
                        </div>
                    </div>
                ';
            })
            ->editColumn('pr_application', function ($db) {
                return $db->category->ms_cat_name;
            })
            ->addColumn('code', function ($db) {
                return $db->pr_code;
            })
            ->editColumn('pr_manufacturer', function ($db) {
                return '
                <div>
                    <div>'.$db->brand->ms_brand_name.'</div>
                    <div>'.$db->pr_supplier.'</div>
                </div>
                ';
            })
            ->editColumn('pr_model', function ($db) {
                return '
                <div>
                    <div>'.$db->pr_model.'</div>
                    <div>'.$db->pr_finishing.'</div>
                </div>
                ';
            })
            ->editColumn('pr_prj_location', function($db){
                return '
                    <div>
                        <div>'.$db->pr_prj_location.'</div>
                        <div class="badge bg-primary" onclick="editProduct(\''.$db->pr_id.'\')" style="cursor:pointer">Click to edit alternative</div>
                    </div>
                ';
            })
            ->rawColumns(['action','lumen', 'pr_manufacturer', 'pr_model', 'pr_prj_location', 'checkbox'])->toJson();
    }

    public function import(Request $request){
        $path = $request->file('file')->getRealPath();

        try {
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
            $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path);
        } catch (Exception $e) {
            $msg = 'Error loading file "' . pathinfo($path, PATHINFO_BASENAME) . '": ' . $e->getMessage();
            echo json_encode(array('status' => 'error;', 'msg' => $msg));
            return false;
        }

        $sheets = $objPHPExcel->getSheetCount();
        for($i = 0; $i < $sheets; $i++){
            $sheet = $objPHPExcel->getSheet($i);

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

            $model = $this->g_data($sheet, $keys);
            $model = $this->g_image($sheet, $model);
        }

        return json_encode(array('status' => 'success', 'msg' => 'Imported successfully'));
    }

    private function g_data($sheet, $keys){
        $data = new Products();
        foreach($keys as $key => $cell){
            $data[$key] = $sheet->getCell($cell)->getValue();
        }

        $data['pr_code'] = str_replace('Code : ', '', $data['pr_code']);

        $brand = MsBrands::whereRaw("LOWER(ms_brand_name) = LOWER('$data[pr_manufacturer]')")->first();
        if($brand){
            $data['pr_manufacturer'] = $brand->ms_brand_id;
        } else {
            $brand = new MsBrands();
            $brand->ms_brand_name = $data['pr_manufacturer'];
            $brand->save();
            $data['pr_manufacturer'] = $brand->ms_brand_id;
        }

        $lumtype = MsLumTypes::whereRaw("LOWER(ms_lum_types_name) = LOWER('$data[pr_luminaire_type]')")->first();
        if($lumtype){
            $data['pr_luminaire_type'] = $lumtype->ms_lum_types_id;
        } else {
            $lumtype = new MsLumTypes();
            $lumtype->ms_lum_types_name = $data['pr_luminaire_type'];
            $lumtype->save();
            $data['pr_luminaire_type'] = $lumtype->ms_lum_types_id;
        }

        $category = MsCategories::whereRaw("LOWER(ms_cat_name) = LOWER('$data[pr_application]')")->first();
        if($category){
            $data['pr_application'] = $category->ms_cat_id;
        } else {
            $category = new MsCategories();
            $category->ms_cat_name = $data['pr_application'];
            $category->save();
            $data['pr_application'] = $category->ms_cat_id;
        }

        $data->save();
        return $data;
    }

    private function g_image($sheet, $model){
        $drawing = $sheet->getDrawingCollection();
        foreach($drawing as $draw){
            if($draw->getCoordinates() == 'A14'){
                $path = 'public\\Product\\'.$model->pr_code.'-'.$model->pr_id.'.main.png';
                $content = file_get_contents($draw->getPath());
                Storage::disk('local')->put($path, $content);
                $model->pr_main_photo = $path;
            }
            else if($draw->getCoordinates() == 'D15' || $draw->getCoordinates() == 'D16' || $draw->getCoordinates() == 'D17'){
                $path = 'public\\Product\\'.$model->pr_code.'-'.$model->pr_id.'.dimension.png';
                $content = file_get_contents($draw->getPath());
                Storage::disk('local')->put($path, $content);
                $model->pr_dimension_photo = $path;
            }
            else if($draw->getCoordinates() == 'C31' || $draw->getCoordinates() == 'C30'){
                $path = 'public\\Product\\'.$model->pr_code.'-'.$model->pr_id.'.photometric.png';
                $content = file_get_contents($draw->getPath());
                Storage::disk('local')->put($path, $content);
                $model->pr_photometric_photo = $path;
            }
        }
        $model->save();
        return $model;
    }

    public function getById($id)
    {
        return Products::find($id)->toJson();
    }

    public function saveF(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = Products::find($request->id) ?? new Products();

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
                $path = 'public\\Product\\'.$dbs->pr_code.'-'.$dbs->pr_id.'.'.$type[$key].'.'.$extension;
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


    public function delF($id)
    {
        try {
            $data = Products::find($id);
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
        $db = Products::find($id);

        // $photometric_photo = url('getimage/'.base64_encode($db->pr_photometric_photo));
        $data['db'] = $db;
        $data['main_photo'] = storage_path('app\\'.$db->pr_main_photo);
        $data['dimension_photo'] = storage_path('app\\'.$db->pr_dimension_photo);
        $data['photometric_photo'] = storage_path('app\\'.$db->pr_photometric_photo);

        $pdf = Pdf::loadView('products.export-pdf', $data);
        return $pdf->stream('invoice.pdf');
    }

    public function exportExcel($id){
        ini_set('memory_limit', '-1');

        $db = Products::with('category', 'brand', 'lumtype')->find($id);

        $editFile = 'export-excell.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($editFile);
        $sheet = $spreadsheet->getSheetByName('Sheet');

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

        $sheet->setCellValue('C10', $db->category->ms_cat_name);
        $sheet->setCellValue('H10', $db->pr_code);
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

        $this->draw_image('main', $main, $spreadsheet, 'A14');
        $this->draw_image('dimension', $dimension, $spreadsheet, 'D16');
        $this->draw_image('photometric', $photometric, $spreadsheet, 'C31');

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($db->pr_code.'-'.$db->pr_id.'.xlsx').'"');
        ob_end_clean();
        ob_start();
        $writer->save('php://output');
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
        $drawing->setWorksheet($sheet->getActiveSheet());
    }

    public function search(Request $request){
        $data = Products::where('pr_code', 'ILIKE', '%'.$request->value.'%')->get();
        if($data && count($data) > 0)
            return json_encode(array('status' => '201', 'data' => $data));
        else return json_encode(array('status' => '400'));
    }
}
