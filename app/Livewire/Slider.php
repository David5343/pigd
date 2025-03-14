<?php

namespace App\Livewire;

use Livewire\Component;

class Slider extends Component
{
    public $currentIndex = 0;
    public $images = [
        '/images/sliders/slider1.png',
        '/images/sliders/slider2.png',
        '/images/sliders/slider3.png'
    ];

    public function next()
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
    }

    public function prev()
    {
        $this->currentIndex = ($this->currentIndex - 1 + count($this->images)) % count($this->images);
    }

    public function render()
    {
        return view('livewire.slider');
    }
}

