<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MarketVolume extends Component
{
    public $project;

    public function render()
    {
        return view('livewire.market-volume');
    }
}
