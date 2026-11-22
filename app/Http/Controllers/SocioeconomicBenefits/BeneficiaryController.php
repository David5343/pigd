<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Beneficiary;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class BeneficiaryController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.beneficiaries.index');

    }
    public function create()
    {
        return view('socioeconomic_benefits.beneficiaries.create');
    }
    public function show(string $id)
    {
        $familiar = Beneficiary::with([
            'insured.subdependency.dependency',
            'insured.affiliationStatus',
            'credentials' => fn ($query) => $query->orderByDesc('issued_at'),
        ])->findOrFail($id);

        $titular = $familiar->insured;
        $nombreFamiliar = collect([$familiar->last_name_1, $familiar->last_name_2, $familiar->name])
            ->filter(fn ($parte) => filled($parte))
            ->implode(' ');

        $datosPersonales = [
            'Fecha de nacimiento' => $this->formatDate($familiar->birthday),
            'Edad' => $this->formatAge($familiar->birthday),
            'RFC' => $familiar->rfc,
            'CURP' => $familiar->curp,
            'Sexo' => $familiar->sex,
            'Capacidades diferentes' => $familiar->disabled_person,
        ];

        $datosDomicilio = [
            'Domicilio registrado' => $familiar->address,
        ];

        $datosAfiliacion = [
            'Folio de afiliación' => $familiar->file_number,
            'Fecha de alta' => $this->formatDate($familiar->start_date),
            'Parentesco' => $familiar->relationship,
            'Estatus de afiliación' => $familiar->affiliate_status,
            'Observaciones' => $familiar->observations,
            'Fecha de baja' => $this->formatDate($familiar->inactive_date),
            'Motivo de baja' => $familiar->inactive_motive,
            'Referencia de baja' => $familiar->inactive_reference,
            'Fecha de reingreso' => $this->formatDate($familiar->reentry_date),
            'Estatus del registro' => $familiar->status,
        ];

        $datosTitular = $titular ? [
            'Nombre del titular' => collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
                ->filter(fn ($parte) => filled($parte))
                ->implode(' '),
            'Folio de afiliación' => $titular->file_number,
            'Número de empleado' => $titular->employee_number,
            'Dependencia' => $titular->subdependency?->dependency?->name,
            'Área o unidad' => $titular->subdependency?->name,
            'Estatus de afiliación' => $titular->affiliationStatus?->name,
        ] : [];

        $credenciales = $familiar->credentials->map(fn ($credencial) => [
            'numero' => $credencial->id,
            'emitida' => $this->formatDate($credencial->issued_at, true),
            'vigente_hasta' => $this->formatDate($credencial->expires_at),
            'tipo_vigencia' => $credencial->expiration_types,
            'estatus' => $credencial->credential_status,
        ]);

        return view('socioeconomic_benefits.beneficiaries.show', [
            'nombreFamiliar' => $nombreFamiliar,
            'folioAfiliacion' => $familiar->file_number,
            'estatusAfiliacion' => $familiar->affiliate_status,
            'fotoUrl' => $familiar->photo
                ? asset('photo/beneficiaries/' . $familiar->file_number . '.jpg')
                : asset('images/icono_no_imagen.png'),
            'datosPersonales' => $datosPersonales,
            'datosDomicilio' => $datosDomicilio,
            'datosAfiliacion' => $datosAfiliacion,
            'datosTitular' => $datosTitular,
            'idTitular' => $titular?->id,
            'credenciales' => $credenciales,
        ]);

    }

    private function formatDate(?string $date, bool $includeTime = false): ?string
    {
        if (blank($date)) {
            return null;
        }

        try {
            return Carbon::parse($date)->format($includeTime ? 'd/m/Y H:i' : 'd/m/Y');
        } catch (Exception) {
            return $date;
        }
    }

    private function formatAge(?string $date): ?string
    {
        if (blank($date)) {
            return null;
        }

        try {
            $fechaNacimiento = Carbon::parse($date);

            return $fechaNacimiento->isFuture() ? null : $fechaNacimiento->age . ' años';
        } catch (Exception) {
            return null;
        }
    }
    public function edit(string $id)
    {
        $row = Beneficiary::find($id);

        return view('socioeconomic_benefits.beneficiaries.edit', ['familiar' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'last_name_1' => ['required', 'max:20'],
            'last_name_2' => ['nullable', 'max:20'],
            'name' => ['required', 'max:30'],
            'birthday' => ['required', 'date'],
            'sex' => ['required'],
            'rfc' => ['nullable', 'max:13', 'alpha_num:ascii', 'unique:beneficiaries,rfc,'.$id],
            'curp' => ['nullable', 'max:18', 'alpha_num:ascii', 'unique:beneficiaries,curp,'.$id],
            'disabled_person' => ['required'],
            'relationship' => ['required'],
            'address' => ['required', 'max:150'],
            'observations' => ['nullable', 'max:150'],
        ]);
        DB::beginTransaction();

        try {

            $row = Beneficiary::find($id);
            $row->start_date = $request->input('start_date');
            $row->last_name_1 = Str::of($request->input('last_name_1'))->trim();
            $row->last_name_2 = Str::of($request->input('last_name_2'))->trim();
            $row->name = Str::of($request->input('name'))->trim();
            $row->birthday = $request->input('birthday');
            $row->sex = $request->input('sex');
            $rfc = Str::of($request->input('rfc'))->trim();
            $row->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('curp'))->trim();
            $row->curp = Str::upper($curp);
            $row->disabled_person = $request->input('disabled_person');
            $row->relationship = $request->input('relationship');
            $row->address = Str::of($request->input('address'))->trim();
            $row->observations = Str::of($request->input('observations'))->trim();
            $row->modified_by = Auth::user()->email;
            $row->save();
            DB::commit();
            session()->flash('msg', 'Registro actualizado con éxito!');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('msg_warning', $e->getMessage());
            return back();
        }
    }
}
