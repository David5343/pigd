<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\ContractType;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class ContractTypeCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|unique:contract_types,name|min:2|max:30')]
    public $name;
    #[Validate('nullable|min:2|max:200')]
    public $description;
    public $msg = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $contract = new ContractType();
            $contract->name = Str::of($this->name)->trim();
            $contract->description = Str::of($this->description)->trim();
            $contract->modified_by = Auth::user()->email;
            $contract->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Tipo de contrato : '.$contract->name.' fué creado con éxito!','success');   
            // Enviar el mensaje a la vista sin necesidad de recargar
         } catch (Exception $e) {
             DB::rollBack();
             $this->dispatch('showMessage', 'Error : '.$e->getMessage().' Contacte a su Administrador.','error');
        }

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.catalogs.contract-type-create');
    }
}
