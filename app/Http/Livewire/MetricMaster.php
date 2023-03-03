<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MetricMaster extends Component
{
    public $project;

    public function render()
    {
        return view('livewire.metric-master');
    }
}
