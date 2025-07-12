<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\SupplierCategory;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class SupplierCategoryCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:5|max:70|unique:supplier_categories,name')]
    public $name = '';
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $supplier_category = new SupplierCategory();
            $supplier_category->name = Str::of($this->name)->trim();
            $supplier_category->modified_by = Auth::user()->email;
            $supplier_category->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'La Categoria de proveedor  : '.$supplier_category->name.' fué creado con éxito!','success');  
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
        return view('livewire.catalogs.supplier-category-create');
    }
}
