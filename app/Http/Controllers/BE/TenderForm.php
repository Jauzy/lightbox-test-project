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
use App\Models\ProjectStageTenderOffered;
use App\Models\ProjectStageTender;

use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TenderForm extends Controller
{
    public function delF($id){
        $tender = ProjectStageTender::find($id);
        $tender->delete();

        $tender_offered = ProjectStageTenderOffered::where('psto_pst_id', $id)->get();
        foreach($tender_offered as $key => $tender){
            foreach($tender->getAttributes() as $key => $val){
                if($key == 'pr_main_photo' || $key == 'pr_photometric_photo' || $key == 'pr_dimension_photo' || $key == 'pr_accessories_photo'){
                    if($val != null){
                        Storage::delete($val);
                    }
                }
            }

            $tender->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
        ]);
    }

    public function saveF(Request $request){
        $input = $request->inp;
        $psto = $request->psto;
        $psp_id = $request->psp_id;
        // remove key
        unset($input['psto']);
        unset($input['psp_id']);
        // dd($input);

        $tender = new ProjectStageTender();
        foreach($psto as $key => $val){
            $tender[$key] = $val;
        }
        $tender->psto_date_input = date('d/m/Y');
        $tender->save();

        $files = null;
        foreach($request->files as $file){
            $files = $file;
        }

        $type = [
            'pr_main_photo' => 'main',
            'pr_dimension_photo' => 'dimension',
            'pr_photometric_photo' => 'photometric',
            'pr_accessories_photo' => 'accessories',
        ];

        foreach($input as $pr_id => $product){
            // unset key
            unset($product['id']);

            $file_product = null;
            if(isset($files[$pr_id])){
                $file_product = $files[$pr_id];
            }

            $offered_ori = ProjectStageProductOffered::find($pr_id);
            $offered = $offered_ori->toArray();
            $data = new ProjectStageTenderOffered();
            $data->psto_psp_id = $psp_id;
            $data->psto_pst_id = $tender->pst_id;
            $data->psto_supplied_as = $product['psto_supplied_as'];
            $data->save();
            foreach($offered as $key => $val){
                // duplicate image [pr_accessories_photo, pr_dimension_photo, pr_photometric_photo, pr_main_photo] to folder tender
                if($key == 'pr_accessories_photo' || $key == 'pr_dimension_photo' || $key == 'pr_photometric_photo' || $key == 'pr_main_photo'){
                    if($val){
                        $path = 'public\\Tender\\'.$offered['pr_code'].'-'.$data['psto_id'].'.'.$type[$key].'.png';
                        Storage::copy($val, $path);
                        $data[$key] = $path;
                    }
                } else if($key == 'pr_luminaire_type'){
                    $data[$key] = $offered_ori->lumtype->ms_lum_types_name;
                } else if($key == 'pr_manufacturer'){
                    $data[$key] = $offered_ori->brand->ms_brand_name;
                } else {
                    $data[$key] = $val;
                }
            }

            if($product['psto_supplied_as'] != 'as-specified'){

                foreach($product as $key => $val){
                    if($key == 'ms_brand_name') $data['pr_manufacturer'] = $val;
                    else
                    $data[$key] = $val;
                }

                if($file_product){
                    foreach($file_product as $k => $f){
                        if($f){
                            $extension = $f->getClientOriginalExtension();
                            $paths = 'public\\Tender\\'.$offered['pr_code'].'-'.$data['psto_id'].'.'.$type[$k].'.'.$extension;
                            $data[$k] = $paths;
                            Storage::disk('local')->put($paths, file_get_contents($f));
                        }
                    }
                }
            }
            $data->save();

            $ori_wattage = (float)preg_replace("/[^0-9]/", "", $offered_ori->pr_light_source);
            $ori_lumen = (float)preg_replace("/[^0-9]/", "", $offered_ori->pr_lumen_output);
            $ori_beam = (float)preg_replace("/[^0-9]/", "", $offered_ori->pr_optical);
            $valid = true;
            $not_valid_reason = [];
            $wattage = (float)preg_replace("/[^0-9]/", "", $data->pr_light_source);
            $lumen = (float)preg_replace("/[^0-9]/", "", $data->pr_lumen_output);
            $beam = (float)preg_replace("/[^0-9]/", "", $data->pr_optical);

            $accepted_gap_wattage = $ori_wattage * 0.1;
            $diff_wattage = abs($wattage - $ori_wattage);
            if($diff_wattage > $accepted_gap_wattage){
                $valid = false;
                $not_valid_reason[] = 'Wattage';
            }

            $accepted_gap_lumen = $ori_lumen * 0.1;
            $diff_lumen = abs($lumen - $ori_lumen);
            if($diff_lumen > $accepted_gap_lumen){
                $valid = false;
                $not_valid_reason[] = 'Lumen';
            }

            $accepted_gap_beam = $ori_beam * 0.15;
            $diff_beam = abs($beam - $ori_beam);
            if($diff_beam > $accepted_gap_beam){
                $valid = false;
                $not_valid_reason[] = 'Beam';
            }

            if($offered_ori->pr_color_temperature != $data->pr_color_temperature){
                $valid = false;
                $not_valid_reason[] = 'Color Temp';
            }

            if($offered_ori->pr_color_rendering != $data->pr_color_rendering){
                $valid = false;
                $not_valid_reason[] = 'CRI';
            }

            if($offered_ori->pr_ip_rating != $data->pr_ip_rating){
                $valid = false;
                $not_valid_reason[] = 'IPR';
            }

            if($offered_ori->pr_driver != $data->pr_driver){
                $valid = false;
                $not_valid_reason[] = 'Driver';
            }

            $data->psto_status = $valid ? 'Comply' : 'Not Comply';
            $data->psto_error = join(",", $not_valid_reason);
            $data->save();
        }
        return json_encode([
            'status' => 'success',
            'message' => 'Data has been saved'
        ]);
    }
}
