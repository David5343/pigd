<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\SocioeconomicBenefits\Beneficiary;
use App\Models\SocioeconomicBenefits\Insured;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BeneficiariesCreate extends Component
{
    public $busqueda='';
    public $file_number_insured = '';
    public $name_insured= '';
    public $insured_id= 0;
    public $rfc='';
    public $folio;
    #[Validate('required | unique:beneficiaries,file_number')]
    public $file_number;
    #[Validate('required|date|max:10')]
    public $start_date = '';
    #[Validate('required | string | max:20')]
    public $last_name_1 = '';
    #[Validate('nullable | max:20')]
    public $last_name_2 = '';
    #[Validate('required | string |max:30')]
    public $name = '';
    #[Validate('required|date|max:10')]
    public $birthday = '';
    #[Validate('required')]
    public $sex = '';
    #[Validate('nullable|max:18|alpha_num:ascii|unique:beneficiaries,curp')]
    public $curp = '';
    #[Validate('required')]
    public $disabled_person = '';
    #[Validate('required')]
    public $relationship = '';
    #[Validate('required | max:150')]
    public $address = '';

    #[Validate('nullable | max:150')]
    public $observations = '';
    public function buscar()
    {
        $row = Insured::where('affiliate_status','Activo')
        ->where('file_number', $this->busqueda)->first();
        if ($row !== null) {
            $this->file_number_insured = $row->file_number;
            $this->name_insured = $row->last_name_1.' '.$row->last_name_2.' '.$row->name;
            $this->insured_id = $row->id;
            $this->rfc = $row->rfc;

        } else {
            //('msg_tipo_busqueda', 'info');
            session()->flash('msg_busqueda', 'No se encontro ningun registro.');
        }

    }
    public function guardar()
    {
        $this->validate();
        $esposa = Beneficiary::where('affiliate_status', 'Activo')
            ->where('insured_id', $this->insured_id)
            ->where('relationship', 'Esposa')->get();
        $concubina = Beneficiary::where('affiliate_status', 'Activo')
            ->where('insured_id', $this->insured_id)
            ->where('relationship', 'Concubina')->get();
        $mama = Beneficiary::where('affiliate_status', 'Activo')
            ->where('insured_id', $this->insured_id)
            ->where('relationship', 'Madre')->get();
        $papa = Beneficiary::where('affiliate_status', 'Activo')
            ->where('insured_id', $this->insured_id)
            ->where('relationship', 'Padre')->get();

            $familiar = new Beneficiary();
            $familiar->file_number = $this->file_number;
            $familiar->start_date = $this->start_date;
            $familiar->last_name_1 = $this->last_name_1;
            $familiar->last_name_2 = $this->last_name_2;
            $familiar->name = $this->name;
            $familiar->birthday = $this->birthday;
            $familiar->sex = $this->sex;
            $familiar->curp = $this->curp;
            $familiar->disabled_person = $this->disabled_person;
            $familiar->relationship = $this->relationship;
            $familiar->address = $this->address;
            $familiar->observations = $this->observations;
            // $familiar->account_number = $this->num_cuenta;
            // $familiar->clabe = $this->clabe;
            // $familiar->bank_id = $this->banco_id;
            // $familiar->representative_name = $this->nombre_representante;
            // $familiar->representative_rfc = $this->rfc_representante;
            // $familiar->representative_curp = $this->curp_representante;
            // $familiar->representative_relationship = $this->parentesco_representante;
            $familiar->insured_id = $this->insured_id;
            $familiar->affiliate_status = 'Activo';
            $familiar->status = 'active';
            $familiar->modified_by = Auth::user()->email;
            switch ($this->parentesco) {
                case 'Padre':
                    if ($papa->count() == 0) {
                        sleep(1);
                        $familiar->save();
                        session()->flash('msg', 'Registro con No. de Expediente: '.$familiar->file_number.' creado con éxito!');
                        $this->js("alert('Registro con No. de Expediente:".$familiar->file_number." creado con éxito!')");
                    } else {
                        session()->flash('msg_warning', 'Ya existe un registro con el parentesco:Padre para este Trabajador');
                        $this->js("alert('Ya existe un registro con el parentesco:Padre para este Trabajador')");
                    }
                    break;
                case 'Madre':
                    if ($mama->count() == 0) {
                        sleep(1);
                        $familiar->save();
                        session()->flash('msg', 'Registro con No. de Expediente: '.$familiar->file_number.' creado con éxito!');
                        $this->js("alert('Registro con No. de Expediente:".$familiar->file_number." creado con éxito!')");
                    } else {
                        session()->flash('msg_warning', 'Ya existe un registro con el parentesco:Madre para este Trabajador');
                        $this->js("alert('Ya existe un registro con el parentesco:Madre para este Trabajador')");
                    }
                    break;
                case 'Esposa':
                    if ($esposa->count() == 0 && $concubina->count() == 0) {
                        sleep(1);
                        $familiar->save();
                        session()->flash('msg', 'Registro con No. de Expediente: '.$familiar->file_number.' creado con éxito!');
                        $this->js("alert('Registro con No. de Expediente:".$familiar->file_number." creado con éxito!')");
                    } else {
                        session()->flash('msg_warning', 'Ya existe un registro con el parentesco:Esposa o Concubina para este Trabajador');
                        $this->js("alert('Ya existe un registro con el parentesco:Esposa o Concubina para este Trabajador')");
                    }
                    break;
                case 'Concubina':
                    if ($concubina->count() == 0 && $esposa->count() == 0) {
                        sleep(1);
                        $familiar->save();
                        session()->flash('msg', 'Registro con No. de Expediente: '.$familiar->file_number.' creado con éxito!');
                        $this->js("alert('Registro con No. de Expediente:".$familiar->file_number." creado con éxito!')");
                    } else {
                        session()->flash('msg_warning', 'Ya existe un registro con el parentesco:Concubina o Esposa para este Trabajador');
                        $this->js("alert('Ya existe un registro con el parentesco:Concubina o Esposa para este Trabajador')");
                    }
                    break;
                case 'Hijo/a':
                    sleep(1);
                    $familiar->save();
                    session()->flash('msg', 'Registro con No. de Expediente: '.$familiar->file_number.' creado con éxito!');
                    $this->js("alert('Registro con No. de Expediente:".$familiar->file_number." creado con éxito!')");
                    break;
                default:
                    break;
            }
    }
    public function render()
    {
        $this->folio = IdGenerator::generate(['table' => 'beneficiaries', 'field' => 'file_number', 'length' => 8, 'prefix' => 'F']);
        $this->file_number = $this->folio;
        return view('livewire.socioeconomic-benefits.beneficiaries-create',['folio' => $this->folio]);
    }
}
