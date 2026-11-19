<?php

namespace App\Http\Controllers\SocioeconomicBenefits;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Bank;
use App\Models\Catalogs\County;
use App\Models\Catalogs\State;
use App\Models\Catalogs\Subdependency;
use App\Models\SocioeconomicBenefits\Insured;
use App\Models\SocioeconomicBenefits\Rank;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    public function index()
    {
        return view('socioeconomic_benefits.membership.index');

    }
    public function create()
    {
        return view('socioeconomic_benefits.membership.create');
    }
    public function show(string $id)
    {
        $titular = Insured::with([
            'subdependency.dependency',
            'rank',
            'workplaceCounty',
            'birthplaceCounty',
            'county.state',
            'affiliationStatus',
            'beneficiaries',
            'credencialInsured' => fn ($query) => $query->orderByDesc('issued_at'),
        ])->findOrFail($id);

        $nombreTitular = collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
            ->filter(fn ($parte) => filled($parte))
            ->implode(' ');

        $datosGenerales = [
            'Folio de afiliación' => $titular->file_number,
            'Fecha de ingreso' => $this->formatDate($titular->start_date),
            'Motivo de registro' => $titular->register_motive,
            'Observaciones' => $titular->observations,
            'Fecha de baja en la dependencia' => $this->formatDate($titular->inactive_date_dependency),
            'Fecha de baja en el sistema' => $this->formatDate($titular->inactive_date),
            'Motivo de baja' => $titular->inactive_motive,
            'Fecha de reingreso' => $this->formatDate($titular->reentry_date),
            'Estatus del registro' => $titular->status,
        ];

        $datosPersonales = [
            'Fecha de nacimiento' => $this->formatDate($titular->birthday),
            'Edad' => $this->formatAge($titular->birthday),
            'Lugar de nacimiento' => $titular->birthplaceCounty?->name,
            'Sexo' => $titular->sex,
            'Estado civil' => $titular->marital_status,
            'RFC' => $titular->rfc,
            'CURP' => $titular->curp,
            'Teléfono' => $titular->phone,
            'Correo electrónico' => $titular->email,
            'Tipo de sangre' => $titular->blood_type,
        ];

        $datosDomicilio = [
            'Tipo de vialidad' => $titular->roadway_type,
            'Calle' => $titular->street,
            'Número exterior' => $titular->outdoor_number,
            'Número interior' => $titular->interior_number,
            'Colonia' => $titular->neighborhood,
            'Código postal' => $titular->cp,
            'Localidad' => $titular->locality,
            'Municipio' => $titular->county?->name,
            'Entidad federativa' => $titular->county?->state?->name,
        ];

        $datosAdscripcion = [
            'Dependencia' => $titular->subdependency?->dependency?->name,
            'Subdependencia' => $titular->subdependency?->name,
            'Categoría' => $titular->rank?->name,
            'Lugar de trabajo' => $titular->workplaceCounty?->name,
            'Número de empleado' => $titular->employee_number,
        ];

        $familiares = $titular->beneficiaries->map(function ($familiar) {
            $nombre = collect([$familiar->last_name_1, $familiar->last_name_2, $familiar->name])
                ->filter(fn ($parte) => filled($parte))
                ->implode(' ');

            return [
                'nombre' => $nombre ?: null,
                'parentesco' => $familiar->relationship,
                'folio' => $familiar->file_number,
                'fecha_ingreso' => $this->formatDate($familiar->start_date),
                'fecha_nacimiento' => $this->formatDate($familiar->birthday),
                'curp' => $familiar->curp,
                'sexo' => $familiar->sex,
                'capacidades_diferentes' => $familiar->disabled_person,
                'estatus' => $familiar->affiliate_status,
            ];
        });

        $credenciales = $titular->credencialInsured->map(fn ($credencial) => [
            'numero' => $credencial->id,
            'emitida' => $this->formatDate($credencial->issued_at, true),
            'vigente_hasta' => $this->formatDate($credencial->expires_at),
            'tipo_vigencia' => $credencial->expiration_types,
            'estatus' => $credencial->credential_status,
        ]);

        return view('socioeconomic_benefits.membership.show', [
            'nombreTitular' => $nombreTitular,
            'folioAfiliacion' => $titular->file_number,
            'estatusAfiliacion' => $titular->affiliationStatus?->name,
            'fotoUrl' => $titular->photo
                ? asset('photo/insureds/' . $titular->file_number . '.jpg')
                : asset('images/icono_no_imagen.png'),
            'datosGenerales' => $datosGenerales,
            'datosPersonales' => $datosPersonales,
            'datosDomicilio' => $datosDomicilio,
            'datosAdscripcion' => $datosAdscripcion,
            'familiares' => $familiares,
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

            if ($fechaNacimiento->isFuture()) {
                return null;
            }

            return $fechaNacimiento->age . ' años';
        } catch (Exception) {
            return null;
        }
    }

    public function edit(string $id)
    {
        $select1 = Subdependency::where('status', 'active')->get();
        $select2 = State::where('status', 'active')->get();
        $select3 = County::where('status', 'active')->get();
        $select4 = Bank::where('status', 'active')->get();
        $select5 = Rank::where('status', 'active')->get();
        $row = Insured::with('Subdependency')
                        ->with('rank')->find($id);

        return view('socioeconomic_benefits.membership.edit', ['select1' => $select1,
            'select2' => $select2,
            'select3' => $select3,
            'select4' => $select4,
            'select5' => $select5,'titular' => $row]);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'subdependency_id' => ['required'],
            'rank_id' => ['required'],
            'start_date' => ['required', 'max:10', 'date'],
            'work_place' => ['nullable', 'min:3', 'max:85'],
            'register_motive' => ['nullable', 'min:3', 'max:120'],
            'affiliate_status' => ['required'],
            'observations' => ['nullable', 'min:5', 'max:180'],
            'last_name_1' => ['required', 'min:2', 'max:20'],
            'last_name_2' => ['nullable', 'min:2', 'max:20'],
            'name' => ['required', 'min:2', 'max:30'],
            'blood_type' =>['required'],
            'birthday' => ['nullable', 'max:10', 'date'],
            'birthplace' => ['nullable', 'min:3', 'max:85'],
            'sex' => ['nullable'],
            'marital_status' => ['nullable'],
            'rfc' => ['required ', 'min:10', 'max:13 ', ' alpha_num:ascii', 'unique:insureds,rfc,'.$id],
            'curp' => ['nullable', 'min:10', ' max:18 ', 'alpha_num:ascii', 'unique:insureds,curp,'.$id],
            'phone' => ['nullable', 'numeric', 'digits:10'],
            'email' => ['nullable', 'email', 'min:5', 'max:50', 'unique:insureds,email,'.$id],
            'state' => ['nullable', 'min:5', 'max:85'],
            'county' => ['nullable', 'min:3', 'max:85'],
            'neighborhood' => ['nullable', 'min:5', 'max:50'],
            'roadway_type' => ['nullable', 'min:5', 'max:50'],
            'street' => ['nullable', 'min:5', 'max:50'],
            'outdoor_number' => ['nullable', 'max:7'],
            'interior_number' => ['nullable', 'max:7'],
            'cp' => ['nullable', 'numeric', 'digits:5'],
            'locality' => ['nullable', 'min:5', 'max:85'],
        ]);
        DB::beginTransaction();

        try {

            $row = Insured::find($id);
            $row->subdependency_id = $request->input('subdependency_id');
            $row->rank_id = $request->input('rank_id');
            $row->start_date = $request->input('start_date');
            $row->work_place = Str::of($request->input('work_place'))->trim();
            $row->register_motive = Str::of($request->input('register_motive'))->trim();
            $row->affiliate_status = $request->input('affiliate_status');
            $row->observations = Str::of($request->input('observations'))->trim();
            $row->last_name_1 = Str::of($request->input('last_name_1'))->trim();
            $row->last_name_2 = Str::of($request->input('last_name_2'))->trim();
            $row->name = Str::of($request->input('name'))->trim();
            $row->birthday = $request->input('birthday');
            $row->birthplace = Str::of($request->input('birthplace'))->trim();
            $row->sex = $request->input('sex');
            $row->marital_status = $request->input('marital_status');
            $rfc = Str::of($request->input('rfc'))->trim();
            $row->rfc = Str::upper($rfc);
            $curp = Str::of($request->input('curp'))->trim();
            $row->curp = Str::upper($curp);
            $row->phone = Str::of($request->input('phone'))->trim();
            $email = Str::of($request->input('email'))->trim();
            $row->email = Str::lower($email);
            $row->state = Str::of($request->input('state'))->trim();
            $row->county = Str::of($request->input('county'))->trim();
            $row->neighborhood = Str::of($request->input('neighborhood'))->trim();
            $row->roadway_type = Str::of($request->input('roadway_type'))->trim();
            $row->street = Str::of($request->input('street'))->trim();
            $row->outdoor_number = Str::of($request->input('outdoor_number'))->trim();
            $row->interior_number = Str::of($request->input('interior_number'))->trim();
            $row->cp = Str::of($request->input('cp'))->trim();
            $row->locality = Str::of($request->input('locality'))->trim();
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
