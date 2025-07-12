<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Supplier;
use App\Models\Catalogs\SupplierCategory;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class SupplierCreate extends Component
{
    public $categories = [];
    public $selectedCategories = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    public $name = '';
    public $rfc = '';
    public $email = '';
    public $office_phone = '';
    public $mobile_phone = '';
    public $address = '';
    public $type = '';
    
    public function mount()
    {
        $this->categories = SupplierCategory::all();
    }
    public function guardar()
    {

    $this->validate([
        'name' => 'required|string|min:5|max:190|unique:suppliers,name',
        'rfc' => 'required|string|regex:/^([A-ZÑ&]{3,4})\d{6}([A-Z\d]{3})$/i|min:12|max:13',
        'email' => 'required|email|max:190',
        'office_phone' => 'required|digits:10',
        'mobile_phone' => 'required|digits:10',
        'address' => 'required|string|max:190',
        'type' => 'required',
        'selectedCategories' => 'required|array|min:1'
    ]);
        try {
            DB::beginTransaction();
            $supplier = new Supplier();
            $supplier->name = Str::of($this->name)->trim();
            $supplier->rfc = Str::of($this->rfc)->trim();
            $supplier->email = Str::of($this->email)->trim();
            // Convertirlo manualmente a E.164 para México
            $office_phoneE164 = '+52' . ltrim($this->office_phone, '0');
            $supplier->office_phone = Str::of($office_phoneE164)->trim();
            $mobile_phoneE164 = '+52' . ltrim($this->mobile_phone, '0');
            $supplier->mobile_phone = Str::of($mobile_phoneE164)->trim();
            $supplier->address = Str::of($this->address)->trim();
            $supplier->type = Str::of($this->type)->trim();
            $supplier->modified_by = Auth::user()->email;
            $supplier->save();
            
            // Guarda relación con las categorías (si tienes tabla pivote supplier_category)
            $supplier->categories()->sync($this->selectedCategories);
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'El proveedor  : '.$supplier->name.' fué creado con éxito!','success');  
         } catch (Exception $e) {
             DB::rollBack();
             $this->dispatch('showMessage', 'Error : '.$e->getMessage().' Contacte a su Administrador.','error');
        }

    }
        public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
        $this->categories = SupplierCategory::all();
    }
    public function render()
    {
        return view('livewire.catalogs.supplier-create');
    }
}
