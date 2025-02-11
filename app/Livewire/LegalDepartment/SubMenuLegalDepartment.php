<?php

namespace App\Livewire\LegalDepartment;

use Livewire\Component;

class SubMenuLegalDepartment extends Component
{
    public $isSubmenu1Visible = false;
    public $isSubmenu2Visible = false;
    public $isSubmenu3Visible = false;
    
    public function toggleSubmenu($submenu)
    {
        if ($submenu === 'submenu1') {
            $this->isSubmenu1Visible = !$this->isSubmenu1Visible;
        } elseif ($submenu === 'submenu2') {
            $this->isSubmenu2Visible = !$this->isSubmenu2Visible;
        } elseif ($submenu === 'submenu3') {
            $this->isSubmenu3Visible = !$this->isSubmenu3Visible;
        }
    }
    private function resetVisibility()
    {
        $this->isSubmenu1Visible = false;
        $this->isSubmenu2Visible = false;
        $this->isSubmenu3Visible = false;
    }
    public function render()
    {
        return view('livewire.legal-department.sub-menu-legal-department');
    }
}
