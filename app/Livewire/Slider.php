<?php

namespace App\Livewire;

use Livewire\Component;

class Slider extends Component
{
    public $currentIndex = 0;
    public $images = [];

    public function mount(): void
    {
        $files = glob(public_path('images/sliders/*')) ?: [];

        $files = array_filter($files, function ($file) {
            return is_file($file)
                && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
        });

        natsort($files);

        $this->images = array_values(array_map(
            fn ($file) => asset('images/sliders/' . basename($file)),
            $files
        ));
    }

    public function next()
    {
        if ($this->images === []) {
            return;
        }

        $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
    }

    public function prev()
    {
        if ($this->images === []) {
            return;
        }

        $this->currentIndex = ($this->currentIndex - 1 + count($this->images)) % count($this->images);
    }

    public function render()
    {
        return view('livewire.slider');
    }
}
