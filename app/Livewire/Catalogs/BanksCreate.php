<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Bank;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class BanksCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|min:3|max:5|unique:banks,key')]
    public $key = '';
    #[Validate('required|max:50')]
    public $name = '';
    #[Validate('required|min:5|max:120')]
    public $legal_name = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $bank = new Bank();
            $bank->key = Str::of($this->key)->trim();
            $bank->name = Str::of($this->name)->trim();
            $bank->legal_name = Str::of($this->legal_name)->trim();
            $bank->status = 'active';
            $bank->modified_by = Auth::user()->email;
            $bank->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Banco  : '.$bank->name.' fué creado con éxito!','success');  
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
        return view('livewire.catalogs.banks-create');
    }
}
