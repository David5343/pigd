<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return response()->json($users);

    }

    public function login(Request $request)
    {
        $response = ['status' => 0,
            'msg' => ''];
        $data = json_decode($request->getContent());
        if (isset($data->email)) {
            $user = User::where('email', $data->email)->first();
            if ($user) {
                if (Hash::check($data->password, $user->password)) {
                    //$token = $user->createToken($data->email);
                    $response['status'] = 1;
                    //$response["token"] = $token->plainTextToken;
                    $response['msg'] = 'Inicio de Session exitoso.';
                    $response['user'] = $user;
                } else {
                    $response['msg'] = 'Estas Credenciales no coinciden con nuestros registros.';
                }
            } else {
                $response['msg'] = 'Usuario no encontrado.';
            }

        } else {
            $response['msg'] = 'Ingrese Parametros validos.';
        }

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

    }
}
