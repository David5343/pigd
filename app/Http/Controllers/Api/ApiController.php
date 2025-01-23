<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('status')) {
            $users = User::where('status', 'active')->get();
        } else {
            $users = User::all();
        }

        return response()->json($users);

    }

    public function login(Request $request)
    {
        $response = ['Status' => 0,
            'Msg' => ''];
        $data = json_decode($request->getContent());
        if (isset($data->email)) {
            $user = User::where('email', $data->email)->first();
            if ($user) {
                if (Hash::check($data->password, $user->password)) {
                    //$token = $user->createToken($data->email);
                    $response['Status'] = 1;
                    //$response["token"] = $token->plainTextToken;
                    $response['Msg'] = 'Inicio de Session exitoso.';
                    $response['User'] = $user;
                } else {
                    $response['Msg'] = 'Estas Credenciales no coinciden con nuestros registros.';
                }
            } else {
                $response['Msg'] = 'Usuario no encontrado.';
            }

        } else {
            $response['Msg'] = 'Ingrese Parametros validos.';
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
