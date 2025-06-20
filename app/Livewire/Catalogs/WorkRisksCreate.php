<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\PensionType;
use App\Models\Catalogs\WorkRisks;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class WorkRisksCreate extends Component
{
     public $pension_types = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:5|max:70|unique:work_risks,name')]
    public $name = '';
    #[Validate('required')]
    public $pension_type_id = '';
    
    public function mount()
    {
        $this->pension_types = PensionType::all();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $work_risks = new WorkRisks();
            $work_risks->name = Str::of($this->name)->trim();
            $work_risks->pension_type_id =$this->pension_type_id;
            $work_risks->modified_by = Auth::user()->email;
            $work_risks->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'El riesgo de trabajo  : '.$work_risks->name.' fué creado con éxito!','success');  
         } catch (Exception $e) {
             DB::rollBack();
             $this->dispatch('showMessage', 'Error : '.$e->getMessage().' Contacte a su Administrador.','error');
        }

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
        $this->pension_types = PensionType::all(); 
    }
    public function render()
    {
        return view('livewire.catalogs.work-risks-create');
    }
}
