<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Category;
use App\Models\Catalogs\Position;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class PositionsCreate extends Component
{
    public $categories= [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent

    #[Validate('required | min:3 | max:3 | unique:positions,position_number')]
    public $position_number = '';
    #[Validate('required|string|min:3|max:50| unique:positions,position_name')]
    public $position_name = '';
    #[Validate('required')]
    public $category_id = '';


    public function mount()
    {
        //permite filtrar solo los puestos disponibles
        $this->categories = Category::whereColumn('covered_position', '<', 'authorized_position')->get();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $position = new Position();
            $position->position_number = Str::of($this->position_number)->trim();
            $position->position_name = Str::of($this->position_name)->trim();
            $position->category_id = Str::of($this->category_id)->trim();
            $position->modified_by = Auth::user()->email;
            $position->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'Puesto  : '.$position->position_name.' fué creado con éxito!','success');  
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
        return view('livewire.catalogs.positions-create');
    }
}
