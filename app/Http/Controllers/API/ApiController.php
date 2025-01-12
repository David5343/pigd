<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return response()->json($users);

    }

    public function login(Request $request)
    {
        $response = [
            'success' => true,
            'message' => null,
            'data' => null,
            'errors' => null,
        ];
        // Validar los datos
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        $validator = Validator::make($request->all(), $validatedData);
        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar errores de validación
            $response['errors'] = $validator->errors()->toArray();

            // $response['debug'] = $request->all();
            return response()->json($response, 200);
        }
        // Buscar usuario
        $user = User::where('email', $validatedData['email'])->first();
        if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
            $response['success'] = false;
            $response['message'] = 'Credenciales Inválidas.';

            return response()->json([$response], 401);
        }
        $response['message'] = 'Login successful.';
        $response['data'] = $user;

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

    }
}
