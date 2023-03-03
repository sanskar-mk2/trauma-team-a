<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Info extends Component
{
    public $project;

    public function render()
    {
        return view('livewire.info');
    }
}
