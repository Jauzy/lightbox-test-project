<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use App\Models\Projects;
use App\Models\ProjectProducts;

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
            return '
                <div>
                    <div>'.$db->prj_name.'</div>
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

}
