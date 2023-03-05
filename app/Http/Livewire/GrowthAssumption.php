<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GrowthAssumption extends Component
{
    public $project;

    public $matrix;

    public function mount()
    {
        $matrix = [];
        foreach ($this->project->marketMetric->strengths as $strength) {
            $matrix[$strength->name] = [];
            foreach ($this->project->extra_years as $year) {
                if ($strength->get_growth_assumption($year) != null) {
                    $matrix[$strength->name][$year] = [$strength->get_growth_assumption($year), $strength->get_growth_assumption($year), 1];
                } else {
                    $matrix[$strength->name][$year] = [0, 0, 0];
                }
            }
        }
        $this->matrix = $matrix;
    }

    public function saveMatrix()
    {
        foreach ($this->matrix as $strength => $years) {
            foreach ($years as $year => $values) {
                if ((int)$values[0] !== $values[1]) {
                    $strength = $this->project->marketMetric->strengths->where('name', $strength)->first();
                    $growth_assumption = $strength->growthAssumptions->where('year', $year);
                    if ($growth_assumption->count() > 0) {
                        $growth_assumption->first()->update(['change' => $values[0]]);
                    } else {
                        $strength->growthAssumptions()->create(['year' => $year, 'change' => $values[0]]);
                    }
                    $this->matrix[$strength->name][$year][1] = $values[0];
                    $this->matrix[$strength->name][$year][2] = 1;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.growth-assumption');
    }
}
