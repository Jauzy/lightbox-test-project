<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Masterdata\MsUsers;

class LoginController extends Controller
{
    public function exe(Request $request)
    {
        // get username & password
        $username = $request->post('username');
        $password = $request->post('password');

        // hash password
        $pass = '$BSSVPRNHGB$' . substr(md5(md5($password)), 0, 50);
        $data = MsUsers::where('user_username', $username)->first();

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan'
            ]);
        }

        if ($data->user_password != $pass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah',
            ]);
        }

        Session::flush();
        Session::put('login', true);
        Session::put('userId', $data->user_id);
        Session::put('userFullname', $data->user_name);
        Session::put('userRole', $data->user_role);
        Session::put('userTender', $data->user_tender_id);

        return redirect('/');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }

}
