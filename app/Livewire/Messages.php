<?php

namespace App\Livewire;

use Livewire\Component;

class Messages extends Component
{
    public $msg = '';
    public $type = '';

    protected $listeners = ['showMessage' => 'setMessage'];

    public function setMessage($message, $type = 'success')
    {
        $this->msg = $message;
        $this->type = $type; // puede ser 'success', 'error', 'warning', etc.
    }

    public function close()
    {
        $this->msg = '';
    }
    public function render()
    {
        return view('livewire.messages');
    }
}
