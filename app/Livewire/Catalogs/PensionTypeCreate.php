<?php

namespace App\Livewire\Catalogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use App\Models\Catalogs\PensionType;
use Livewire\Component;
use Illuminate\Support\Str;

class PensionTypeCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|unique:pension_types,name|min:2|max:30')]
    public $name;
    public $msg = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $pension_type = new PensionType();
            $pension_type->name = Str::of($this->name)->trim();
            $pension_type->modified_by = Auth::user()->email;
            $pension_type->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Tipo de pensión : '.$pension_type->name.' fué creado con éxito!','success');
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
        return view('livewire.catalogs.pension-type-create');
    }
}
