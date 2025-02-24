<?php

namespace App\Livewire\SocioeconomicBenefits;

use App\Models\Catalogs\Bank;
use App\Models\Catalogs\County;
use App\Models\Catalogs\State;
use App\Models\Catalogs\Subdependency;
use App\Models\SocioeconomicBenefits\Rank;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MembershipCreate extends Component
{
    #[Validate('required|max:8|unique:insureds,file_number')]
    public $folio;

    #[Validate('required')]
    public $subdepe_id;

    #[Validate('required')]
    public $categoria_id;

    #[Validate('required|max:10|date')]
    public $fecha_ingreso;

    #[Validate('nullable|min:3|max:85')]
    public $lugar_trabajo;

    #[Validate('nullable|min:3|max:120')]
    public $motivo_alta;

    #[Validate('required')]
    public $estatus_afiliado;

    #[Validate('nullable|min:5|max:180')]
    public $observaciones;

    #[Validate('required|min:2|max:20')]
    public $apaterno;

    #[Validate('required|min:2|max:20')]
    public $amaterno;

    #[Validate('nullable|min:2|max:30')]
    public $nombre;

    #[Validate('nullable|max:10|date')]
    public $fecha_nacimiento;

    #[Validate('nullable | min:3| max:85')]
    public $lugar_nacimiento;

    #[Validate('required')]
    public $sexo;

    #[Validate('nullable')]
    public $estado_civil;

    #[Validate('required|max:13|alpha_num:ascii|unique:insureds,rfc')]
    public $rfc;

    #[Validate('nullable|max:18|alpha_num:ascii|unique:insureds,curp')]
    public $curp;

    #[Validate('nullable|numeric|digits:10')]
    public $telefono;

    #[Validate('nullable|email|min:5|max:50|unique:insureds,email')]
    public $email;

    #[Validate('nullable|min:5|max:85')]
    public $estado;

    #[Validate('nullable|min:3|max:85')]
    public $municipio;

    #[Validate('nullable|min:5|max:50')]
    public $colonia;

    #[Validate('nullable|min:5|max:50')]
    public $tipo_vialidad;

    #[Validate('nullable|min:5|max:50')]
    public $calle;

    #[Validate('nullable|max:7')]
    public $num_exterior;

    #[Validate('nullable|max:7')]
    public $num_interior;

    #[Validate('nullable|numeric|digits:5')]
    public $cp;

    #[Validate('nullable|min:5|max:85')]
    public $localidad;

    #[Validate('nullable|digits:10')]
    public $num_cuenta;

    #[Validate('nullable|digits:18')]
    public $clabe;

    #[Validate('nullable')]
    public $banco_id;

    #[Validate('nullable| max:40')]
    public $nombre_representante;

    #[Validate('nullable|max:13|alpha_num:ascii')]
    public $rfc_representante;

    #[Validate('nullable| max:18|alpha_num:ascii')]
    public $curp_representante;

    #[Validate('nullable')]
    public $parentesco_representante;
    public function render()
    {
        $select1 = Subdependency::where('status', 'active')->get();
        $select2 = State::where('status', 'active')->get();
        $select3 = County::where('status', 'active')->get();
        $select4 = Bank::where('status', 'active')->get();
        $select5 = Rank::where('status', 'active')->get();
        $this->folio = IdGenerator::generate(['table' => 'insureds', 'field' => 'file_number', 'length' => 8, 'prefix' => 'T']);
        return view('livewire.socioeconomic-benefits.membership-create', ['select1' => $select1,
        'select2' => $select2,
        'select3' => $select3,
        'select4' => $select4,
        'select5' => $select5,
        'folio' => $this->folio]);
    }
}
