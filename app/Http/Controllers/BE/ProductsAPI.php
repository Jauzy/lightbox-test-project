<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Models\Products;

class ProductsAPI extends Controller
{

    public function list()
    {
        $data = Products::all();
        return datatables($data)
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
            ->addColumn('lumen', function ($db) {
                $url = url('getimage/'.base64_encode($db->pr_main_photo));

                return '
                    <div class="d-flex align-items-center" style="gap:10px">
                        <img src="'.$url.'" alt="image" class="rounded" style="height:80px;width:80px;object-fit:contain">
                        <div>
                            <a href="'.url('products/'.$db->pr_id.'/form').'" class="text-primary fw-bolder"><strong>'.$db->pr_code.'</strong></a>
                            <div>'.$db->pr_luminaire_type.'</div>
                            <div>'.$db->pr_lamp_type.' | '.$db->pr_light_source.' | '.$db->pr_lumen_output.'</div>
                        </div>
                    </div>
                ';
            })
            ->addColumn('code', function ($db) {
                return $db->pr_code;
            })
            ->editColumn('pr_manufacturer', function ($db) {
                return '
                <div>
                    <div>'.$db->pr_manufacturer.'</div>
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
            ->rawColumns(['action','lumen', 'pr_manufacturer', 'pr_model'])->toJson();
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
        $data->save();
        return $data;
    }

    private function g_image($sheet, $model){
        $drawing = $sheet->getDrawingCollection();
        foreach($drawing as $draw){
            if($draw->getCoordinates() == 'A14'){
                $path = 'Product/'.$model->pr_code.'-'.$model->pr_id.'.main.png';
                $content = file_get_contents($draw->getPath());
                Storage::disk('local')->put($path, $content);
                $model->pr_main_photo = $path;
            }
            else if($draw->getCoordinates() == 'D15' || $draw->getCoordinates() == 'D16' || $draw->getCoordinates() == 'D17'){
                $path = 'Product/'.$model->pr_code.'-'.$model->pr_id.'.dimension.png';
                $content = file_get_contents($draw->getPath());
                Storage::disk('local')->put($path, $content);
                $model->pr_dimension_photo = $path;
            }
            else if($draw->getCoordinates() == 'C31' || $draw->getCoordinates() == 'C30'){
                $path = 'Product/'.$model->pr_code.'-'.$model->pr_id.'.photometric.png';
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
                $path = 'Product/'.$dbs->pr_code.'-'.$dbs->pr_id.'.'.$type[$key].'.'.$extension;
                Storage::disk('local')->put($path, file_get_contents($file));
                $dbs[$key] = $path;
            }

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
            Products::find($id)->delete();

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

}
