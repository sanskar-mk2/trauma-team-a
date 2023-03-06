<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MetricMaster extends Component
{
    public $project;

    public $project_name;

    public function mount()
    {
        $this->project_name = [$this->project->name, $this->project->name];
    }

    public function save()
    {
        if ($this->project_name[0] !== $this->project_name[1]) {
            $this->project->update(['name' => $this->project_name[0]]);
            $this->project_name[1] = $this->project_name[0];
        }
    }

    public function render()
    {
        return view('livewire.metric-master');
    }
}
