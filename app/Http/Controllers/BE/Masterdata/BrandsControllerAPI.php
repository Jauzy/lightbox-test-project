<?php

namespace App\Http\Controllers\BE\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;

use App\Models\Masterdata\MsBrands;

class BrandsControllerAPI extends Controller
{

    public function dt()
    {
        $data = MsBrands::all();
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('action', function ($db) {
                return '<a href="javascript:edit(\''.$db->ms_brand_id.'\')" title="Edit Data" class="btn btn-sm btn-icon btn-primary"><i class="bx bx-edit"></i></a>
                        <a href="javascript:del(\''.$db->ms_brand_id.'\')" title="Delete Data" class="btn btn-sm btn-icon btn-danger"><i class="bx bx-trash"></i></a>';
            })
            ->rawColumns(['action'])->toJson();
    }

    public function save(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = MsBrands::find($request->ms_brand_id) ?? new MsBrands();

            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }

            if ($dbs->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan data',
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan data',
        ]);
    }

    public function getById($id)
    {
        return MsBrands::find($id)->toJson();
    }

    public function delete($id)
    {
        try {
            MsBrands::find($id)->delete();

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
