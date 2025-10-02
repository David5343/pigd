<?php

namespace App\Http\Controllers\Api\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Pensioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PensionerApiController extends Controller
{
    public function index()
    {
        try {
            $relations = [
                'subdependency',
                'beneficiaries',
            ];

            $pensioners = Pensioner::with($relations)
                ->latest()
                ->limit(25)
                ->get();

            if ($pensioners->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'insureds' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioners' => $pensioners,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $relations = [
                'subdependency',
                'county.state',
            ];

            $pensioner = Pensioner::with($relations)
                ->where('id', $id)
                ->first();

            if (! $pensioner) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Búsqueda realizada correctamente',
                'pensioner' => $pensioner,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function photo(Request $request, $id)
    {
        $rules = [
            'Noi_number' => 'required|string|max:8',
            'Photo' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'pensioner' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $pensioner = Pensioner::findOrFail($id);
            if (! $pensioner) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $pensioner->photo = Str::of($request->input('Photo'))->trim();
            $pensioner->modified_by = Auth::user()->email;
            $pensioner->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
                'pensioner' => $pensioner,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function signature(Request $request, $id)
    {
        $rules = [
            'Noi_number' => 'required|string|max:8',
            'Signature' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Error de validación',
                'pensioner' => null,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $pensioner = Pensioner::findOrFail($id);
            if (! $pensioner) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Registro no encontrado',
                    'pensioner' => null,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }
            $pensioner->signature = Str::of($request->input('Signature'))->trim();
            $pensioner->modified_by = Auth::user()->email;
            $pensioner->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente',
                'pensioner' => $pensioner,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'fail',
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
